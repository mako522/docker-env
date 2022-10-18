<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Validator;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::withCount('like')->orderBy('id', 'desc')->paginate(10);
        

        $query = Review::query();

        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where('caption', 'like', '%' . $keyword . '%');
        }
        $perpage = $request->input('perpage', 10);

        $reviews = $query->paginate($perpage);

        if (auth()->user()) {
            $query->with(['like'=>function ($query) {
                $query->where('user_id', '=', auth()->user()->id);
            }]);
        }   
        $query->orderby('id','ASC');
        $reviews = $query->paginate(15)->appends( $request->Query() );
        
        return view('index', ['reviews' => $reviews->appends($request->except('page')), 'request'=>$request->except('page')]);
            

    }
    public function new()
    {
        return view('review');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , ['caption' => 'required|max:255', 'photo' => 'required']);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $review = new Review;
        $review->caption = $request->caption;
        $review->user_id = Auth::user()->id;

        $review->save();
        
        $request->photo->storeAs('public/post_images', $review->id . '.jpg');
        
        return redirect('/posts/home');

    }
    
    public function like_review(Request $request)
    {
        $id = Auth::user()->id;
        $review_id = $request->review_id;
        $like = new Like;
        $review = Review::findOrFail($review_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $review_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('review_id', $review_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->review_id = $request->review_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $reviewLikeCount = $review->loadCount('like')->like_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'postLikeCount' => $reviewLikeCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    } 
}
