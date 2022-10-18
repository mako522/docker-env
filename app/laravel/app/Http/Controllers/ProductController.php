<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Time;
use App\User;
use App\Order;
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
        $cartData = [
            'session_products_id' => $request->products_id, 
            'session_quantity' => $request->product_quantity, 
        ];
        if (!$request->session()->has('cartData')) {
            $request->session()->push('cartData', $cartData);
        } else {
            $sessionCartData = $request->session()->get('cartData');

            $isSameProductId = false;
            foreach ($sessionCartData as $index => $sessionData) {
                if ($sessionData['session_products_id'] === $cartData['session_products_id'] ) {
                    $isSameProductId = true;
                    $quantity = $sessionData['session_quantity'] + $cartData['session_quantity'];
                    $request->session()->put('cartData.' . $index . '.session_quantity', $quantity);
                    break;
                }
            }

            if ($isSameProductId === false) {
                $request->session()->push('cartData', $cartData);
            }
        }

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
        $sessionUser = User::find($request->session()->get('users_id'));
        $times = Time::all();

        if ($request->session()->has('cartData')) {
            $cartData = array_values($request->session()->get('cartData'));
        }

        if (!empty($cartData)) {
            $sessionProductsId = array_column($cartData, 'session_products_id');
            $product = Product::find($sessionProductsId);

            foreach ($cartData as $index => &$data) {
                $data['bread_name'] = $product[$index]->bread_name;
                $data['price'] = $product[$index]->price;
                $data['itemPrice'] = $data['price'] * $data['session_quantity'];
            }
            $totalPrice = number_format(array_sum(array_column($cartData, 'itemPrice')));
            unset($data);
            

            return view('user.cartlist', compact('sessionUser', 'cartData', 'totalPrice', 'times'));

        } else {

            return view('user.no_cart_list',  ['user' => Auth::user()]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | カート内商品の削除
    |--------------------------------------------------------------------------
    */
    public function remove(Request $request)
    {
        $sessionCartData = $request->session()->get('cartData');

        $removeCartItem = [
            ['session_products_id' => $request->product_id, 
            'session_quantity' => $request->product_quantity]
        ];

        $removeCompletedCartData = array_udiff($sessionCartData, $removeCartItem, function ($sessionCartData, $removeCartItem) {
            $result1 = $sessionCartData['session_products_id'] - $removeCartItem['session_products_id'];
            $result2 = $sessionCartData['session_quantity'] - $removeCartItem['session_quantity'];
            return $result1 + $result2;
        });

        $request->session()->put('cartData', $removeCompletedCartData);
        //上書き後のsession再取得
        $cartData = $request->session()->get('cartData');

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
        


        $order = new \App\Order;
        $order->user_id = Auth::user()->id;
        $order->order_date = $now;
        $order->order_number = rand();
        $order->time_name = $request->time_name;
        Auth::user()->order()->save($order);
        $savedorder = Order::where('user_id', $order->user_id)->get();
        $savedorderId = $savedorder->pluck('id')->toArray();
        

        foreach ((array)$cartData as $data) {
            $orderDetail = new \App\OrdersDetail;
            $orderDetail->product_id = $data['session_products_id'];
            $orderDetail->order_id = $savedorderId[0];
            $orderDetail->order_quantity = $data['session_quantity'];
            $orderDetail->save();
        }

        //session削除
        $request->session()->forget('cartData');
        return view('completed', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | 商品詳細画面
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $product = Product::find($id);
        if (!empty($product)) {
            $category_name = Category::find($product->category_id);
            $user = Auth::user();
            return view('products.productInfo', compact('product', 'category_name', 'user'));
        }

            return redirect()->route('noProduct');
    }
}
