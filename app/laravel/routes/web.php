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
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/create_income',[RegistrationController::class,'createIncomeForm'])->name('create.income');
    Route::post('/create_income',[RegistrationController::class,'createIncome']);
/*
|--------------------------------------------------------------------------
| カート内商品関連
|--------------------------------------------------------------------------
*/

    Route::group(['middleware'=>'can:view,bread'],function(){
        Route::get('/bread/{bread}/detail',[DisplayController::class,'breadDetail'])->name('bread.detail');

    });
});
