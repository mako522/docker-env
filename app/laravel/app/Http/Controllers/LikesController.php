<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Review;
use Auth;
use Validator;


class LikesController extends Controller
{
    public function store($reviewId)
    {
        Auth::user()->like($reviewId);
        return 'ok!'; //レスポンス内容
    }

    public function destroy($postId)
    {
        Auth::user()->unlilikeke($reviewId);
        return 'ok!'; //レスポンス内容
    }
}
