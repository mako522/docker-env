<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateData;
use Illuminate\Support\Facades\Hash;

class DisplayController extends Controller
{
    public function breadDetail(Bread $breads)
    {   
        
        return view('breads/bread_form',[
           'breads'=>$breads,
       ]);
    }
    public function index(){
        $bread=new Bread;

        $breads = $bread->all();

        $all = $bread->all()->toArray();

        return view('home',compact('breads'));
            
        

    }
}
