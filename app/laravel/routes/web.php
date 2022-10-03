<?php

use App\Http\Controllers\DisplayController;

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
    Route::get('/create_income',[RegistrationController::class,'createIncomeForm'])->name('create.income');
    Route::post('/create_income',[RegistrationController::class,'createIncome']);
/*
|--------------------------------------------------------------------------
| カート内商品関連
|--------------------------------------------------------------------------
*/

    Route::group(['prefix' => 'product'], function () {
        Route::get('detail/{id}/',[DisplayController::class,'breadDetail'])->name('bread.detail');

    });

    Route::resource('cartlist', 'ProductController', ['only' => ['index']]);
    Route::group(["prefix" => 'iteminfo'], function() {
        Route::get('/{id}', 'ProductController@show');
        Route::post('/add', 'ProductController@addCart')->name('addcart.post');
    });

    Route::get('/category',[CategoryController::class,'createCategoryForm'])->name('create.category');
    Route::post('/category',[CategoryController::class,'createCategory']);

// });
// Route::resource('cartitem', 'CartController', ['only' => ['index']]);

// Route::group(["prefix" => 'productInfo'], function() {
//     Route::get('/{id}', 'CartController@show');
//     Route::get('/addCart','ProductController@addCart')->name('addcart.post');
// });
});