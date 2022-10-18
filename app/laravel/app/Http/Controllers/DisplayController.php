<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateData;
use Illuminate\Support\Facades\Hash;

class DisplayController extends Controller
{
    
    public function breadDetail($id)
    {   
        $product = Product::find($id);
        $user = User::find($id);
        
        return view('iteminfo',[
            'product' => $product,
            'user' => $user,
        ]);
        
    }
    public function index(){
        $product = new Product;

        $products = $product->all();

        return view('home',compact('products'));
        
    }
}
