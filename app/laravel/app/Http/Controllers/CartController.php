<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Order;
use App\Kart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    public function show($id)
    {
        //変数の初期化
        $ProductInfo = array();
        $ProductCategory = array();
        $UserId = '';
        //urlパラメータから飛んできたユーザidを元にモデルからそれぞれ商品、カテゴリーを特定
        $ProductInfo = Product::findOrFail($id);
        $ProductCategory = Category::findOrFail($ProductInfo -> category_id);
        $UserId = Auth::user()->id;

        return view('iteminfo', 
        [
            'ProductInfo' => $ProductInfo,
            'ProductCategory' => $ProductCategory,
            'UserId' => $UserId,
        ]);
    }
}
