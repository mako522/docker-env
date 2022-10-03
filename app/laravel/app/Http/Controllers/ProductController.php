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

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 商品詳細 → カート画面へのSession情報保存
    |--------------------------------------------------------------------------
    */
    public function addCart(Request $request)
    {
        

        //セッションに保存したい変数を定義する（ここでは商品idと注文個数）
        //飛んできた$requestの中のname属性をそれぞれ指定
        $SessionProductId = $request->ProductId;
        $SessionProductQuantity = $request->Quantity;
        //配列の入れ物を作る（初期化）
        $SessionData = array();


        //作った配列に、compact関数を用いてidと個数の変数をまとめる（”” を使っているが変数の意味）
        $SessionData = compact("SessionProductId", "SessionProductQuantity");
        var_dump($SessionProductId);

        //session_dataというキーで、$SessionDataをセッションに登録
        $request->session()->push('session_data', $SessionData);

        return redirect('cartlist');

    }

    /*
    |--------------------------------------------------------------------------
    | カート内商品表示
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        User::find($request->session()->get('users_id'));
        $SessionData = $request->session()->get('session_data');
        //セッションデータのなかのそれぞれのデータを抽出
        $SessionProductId = array_column($SessionData, 'SessionProductId');
        $SessionProductQuantity = array_column($SessionData, 'SessionProductQuantity');
        dd($SessionData);
        
    }
    /*
    |--------------------------------------------------------------------------
    | カート内商品の削除
    |--------------------------------------------------------------------------
    */
    public function remove(Request $request)
    {
        //session情報の取得（product_idと個数の2次元配列）
        $sessionCartData = $request->session()->get('cartData');

        //削除ボタンから受け取ったproduct_idと個数を2次元配列に
        $removeCartItem = [
            ['session_products_id' => $request->product_id, 
            'session_quantity' => $request->product_quantity]
        ];

        //sessionデータと削除対象データを比較、重複部分を削除し残りの配列を抽出
        $removeCompletedCartData = array_udiff($sessionCartData, $removeCartItem, function ($sessionCartData, $removeCartItem) {
            $result1 = $sessionCartData['session_products_id'] - $removeCartItem['session_products_id'];
            $result2 = $sessionCartData['session_quantity'] - $removeCartItem['session_quantity'];
            return $result1 + $result2;
        });

        //上記の抽出情報でcartDataを上書き処理
        $request->session()->put('cartData', $removeCompletedCartData);
        //上書き後のsession再取得
        $cartData = $request->session()->get('cartData');

        //session情報があればtrue
        if ($request->session()->has('cartData')) {
            return redirect()->route('cartlist.index');
         }

        return view('products.no_cart_list', ['user' => Auth::user()]);
    }

    /*
    |--------------------------------------------------------------------------
    | カート内商品注文確定(DB登録)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        //$request->session()->forget('cartData');
        $cartData = $request->session()->get('cartData');
        $now = Carbon::now();

        //オブジェクト生成
        $order = new \App\Order;
        //指定値をオブジェクト代入
        $order->user_id = Auth::user()->id;
        $order->order_date = $now;
        $order->order_number = rand();
        //認証済みのユーザーのみオブジェクトへ保存
        Auth::user()->orders()->save($order);

        //Qrderテーブルの カラム「order_number」が「$order->order_number」の値を取得
        $savedOrder = Order::where('order_number', $order->order_number)->get();
        //上記Collectionから id の値だけを取得した配列に変換
        $savedOrderId = $savedOrder->pluck('id')->toArray();

        //注文詳細情報保存を注文数分繰り返す １回のリクエストを複数カラムに分けDB登録
        foreach ($cartData as $data) {
            //注文詳細情報に関わるオブジェクト生成
            $orderDetail = new \App\OrderDetail;
            $orderDetail->product_id = $data['session_products_id'];
            $orderDetail->order_id = $savedOrderId[0];
            $orderDetail->shipment_status_id = 1;
            $orderDetail->order_quantity = $data['session_quantity'];
            $orderDetail->shipment_date = $now;
            $orderDetail->save();
        }

        //session削除
        $request->session()->forget('cartData');
        return view('products/purchase_completed', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | 商品詳細画面
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        //変数の初期化
        $ProductInfo = array();
        
        $UserId = '';
        //urlパラメータから飛んできたユーザidを元にモデルからそれぞれ商品、カテゴリーを特定
        $ProductInfo = Product::findOrFail($id);

        $UserId = Auth::user()->id;

        

        return view('iteminfo', 
        [
            'ProductInfo' => $ProductInfo,
            
            'UserId' => $UserId,
        ]);
    }
}
