<?php

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TimeselectController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LikesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', [DisplayController::class, 'index']);

    Route::get('product/detail/{id}/',[DisplayController::class,'breadDetail'])->name('bread.detail');
    
/*
|--------------------------------------------------------------------------
| カート内商品関連
|--------------------------------------------------------------------------
*/


    Route::resource('cartlist', 'ProductController', ['only' => ['index']]);
    Route::post('productInfo/addCart/cartListRemove', 'ProductController@remove')->name('itemRemove');
    Route::post('productInfo/addCart','ProductController@addCart')->name('addcart.post');
    
    Route::post('productInfo/addCart/orderFinalize','ProductController@store')->name('orderFinalize');

    // Route::resource('cartlist', 'ProductController', ['only' => ['index']]);
    // Route::group(["prefix" => 'iteminfo'], function() {
    //     Route::get('/{id}', 'ProductController@show');
    //     Route::post('/add', 'ProductController@addCart')->name('addcart.post');
    // });

    Route::get('/posts/home', 'PostsController@index')->name('review');//一覧
    
    // Route::resource('products', 'PostsController');
    // Route::post('/like_review', 'PostsController@like_review');


    Route::get('/posts/new', 'PostsController@new')->name('new');
    Route::post('/posts','PostsController@store');


    // //いいね処理
    // Route::get('/posts/{review_id}/likes', 'LikesController@store');
    // Route::get('/likes/{like_id}', 'LikesController@destroy');

    
    Route::post('/like_review', 'LikesController@like')->name('reviews.like');

    Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
        Route::get('/timeselect', [TimeselectController::class, 'selectTimeForm'])->name('select.time');
        Route::post('/timeselect', [TimeselectController::class, 'selectTime'])->name('create.time');

        Route::get('/addtime',[CategoryController::class,'createTimeForm'])->name('add.time');
        Route::post('/addtime',[CategoryController::class,'createTime']);
        
        
        Route::get('/edit/{id}', [UpdateController::class, 'edit'])->name('book.edit');
        Route::post('/update/{id}', [UpdateController::class, 'update'])->name('book.update');
        
        Route::post('/destroy/{id}', [DeleteController::class, 'destroy'])->name('time.destroy');
    });
    

    
// });
// Route::resource('cartitem', 'CartController', ['only' => ['index']]);

// Route::group(["prefix" => 'productInfo'], function() {
//     Route::get('/{id}', 'CartController@show');
//     Route::get('/addCart','ProductController@addCart')->name('addcart.post');
// });
});