<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateData;
use Illuminate\Support\Facades\Hash;

class TimeselectController extends Controller
{
    public function selectTimeForm()
    {
        $times = Time::all();
        return view('timeselect', [
            'times' => $times,
        ]);
    }
    
    
    
    public function selectTime(CreateData $request){
        $times = new Time;

        var_dump($times);

        $times->time_name=$request->time_name;
        
        $times->save();
 
        return redirect('/');
    }
}

