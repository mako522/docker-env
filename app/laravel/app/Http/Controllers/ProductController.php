<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Bread;
use App\User;
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
        //商品詳細画面のhidden属性で送信（Request）された商品IDと注文個数を取得し配列として変数に格納
        //inputタグのname属性を指定し$requestからPOST送信された内容を取得する。
        $cartData = [
            'session_products_id' => $request->products_id, 
            'session_quantity' => $request->product_quantity, 
        ];

        //sessionにcartData配列が「無い」場合、商品情報の配列をcartData(key)という名で$cartDataをSessionに追加
        if (!$request->session()->has('cartData')) {
            $request->session()->push('cartData', $cartData);
        } else {
            $sessionCartData = $request->session()->get('cartData');


            $isSameProductId = false;
            foreach ($sessionCartData as $index => $sessionData) {
                //product_idが同一であれば、フラグをtrueにする → 個数の合算処理、及びセッション情報更新。更新は一度のみ
                if ($sessionData['session_products_id'] === $cartData['session_products_id'] ) {
                    $isSameProductId = true;
                    $quantity = $sessionData['session_quantity'] + $cartData['session_quantity'];
                    //cartDataをrootとしたツリー状の多次元連想配列の特定のValueにアクセスし、指定の変数でValueの上書き処理
                    $request->session()->put('cartData.' . $index . '.session_quantity', $quantity);
                    break;
                }
            }

            //product_idが同一ではない状態を指定 その場合であればpushする
            if ($isSameProductId === false) {
                $request->session()->push('cartData', $cartData);
            }
        }

        //POST送信された情報をsessionに保存 'users_id'(key)に$request内の'users_id'をセット
        $request->session()->put('users_id', ($request->users_id));
        return redirect()->route('cartlist.index');
    }

    /*
    |--------------------------------------------------------------------------
    | カート内商品表示
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        //渡されたセッション情報をkey（名前）を用いそれぞれ取得、変数に代入
        $sessionUser = User::find($request->session()->get('users_id'));

        //removeメソッドでの配列削除時の配列連番抜け対策
        if ($request->session()->has('cartData')) {
            $cartData = array_values($request->session()->get('cartData'));
        }

        if (!empty($cartData)) {
            $sessionProductsId = array_column($cartData, 'session_products_id');
            $product = Product::with('category')->find($sessionProductsId);

            foreach ($cartData as $index => &$data) {
                //二次元目の配列を指定している$dataに'product〜'key生成 Modelオブジェクト内の各カラムを代入
                //＆で参照渡し 仮引数($data)の変更で実引数($cartData)を更新する
                $data['bread_name'] = $product[$index]->product_name;
                
                $data['price'] = $product[$index]->price;
                //商品小計の配列作成し、配列の追加
                $data['itemPrice'] = $data['price'] * $data['session_quantity'];
            }

            unset($data);

            return view('products.cartlist', compact('sessionUser', 'cartData', 'totalPrice'));

        } else {

            return view('products.no_cart_list',  ['user' => Auth::user()]);
        }
    }

}