<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;
use Validator;

class PostsController extends Controller
{
    public function index(Request $request)
    {
            $query = Review::query();

            $keyword = $request->input('keyword');
            if (!empty($keyword)) {
                $query->where('caption', 'like', '%' . $keyword . '%');
            }
    
            $perpage = $request->input('perpage', 10);
            
    
            $reviews = $query->paginate($perpage);
            
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
}
