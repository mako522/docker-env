<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Review;
use Illuminate\Support\Facades\Auth;
use Validator;

class LikesController extends Controller
{

    public function like(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $review_id = $request->review_id; //2.投稿idの取得
        $already_liked = Like::where('user_id', $user_id)->where('review_id', $review_id)->first(); //3.

        if (!$already_liked) { 
            $like = new Like; 
            $like->review_id = $review_id;
            $like->user_id = $user_id;
            $like->save();
        } else { 
            Like::where('review_id', $review_id)->where('user_id', $user_id)->delete();
        }
        
        $review_like_count = Review::withCount('like')->findOrFail($review_id)->like_count;
        $param = [
            'review_like_count' => $review_like_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
}

