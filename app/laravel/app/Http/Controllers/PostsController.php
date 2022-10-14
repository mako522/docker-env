<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Like;
use Auth;
use Validator;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
            $query = Review::query();

            $keyword = $request->input('keyword');
            if (!empty($keyword)) {
                $query->where('caption', 'like', '%' . $keyword . '%');
            }
    
            $perpage = $request->input('perpage', 10);
            
            $reviews = $query->paginate($perpage);
            $like_model = new Like;
            $data = [
                'reviews' => $reviews,
                'like_model'=>$like_model,
            ];
            
            return view('index', ['reviews' => $reviews->appends($request->except('page')), 'request'=>$request->except('page'),'like_model'=>$like_model,'data'=>$data]);

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
    public function ajaxlike(Request $request)
    {
        $id = Auth::user()->id;
        $review_id = $request->review_id;
        $like = new Like;
        $review = Review::findOrFail($review_id);

        
        if ($like->like_exist($id, $review_id)) {
            
            $like = Like::where('review_id', $review_id)->where('user_id', $id)->delete();
        } else {
            
            $like = new Like;
            $like->review_id = $request->review_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }
        $reviewLikesCount = $post->loadCount('likes')->likes_count;

        
        $json = [
            'reviewLikesCount' => $reviewLikesCount,
        ];
        
        return response()->json($json);
    }
}
