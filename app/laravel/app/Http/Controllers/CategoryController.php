<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateData;


class CategoryController extends Controller
{
       
    public function createTimeForm()
    {
        $params = Time::where('time_name')->get();

        return view('addtime',[
           'times'=>$params,
        ]);
    }
    public function createTime(Request $request)
    {   
        $times = new Time;

        $times->time_name=$request->time_name;
        
        $times->save();
        
        return redirect('/timeselect');
    }
    
}
