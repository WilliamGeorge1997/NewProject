<?php

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



Route::prefix('admin')->group(function () {
    Route::resource('ordermethods', 'OrderMethodController');
    Route::get('ordermethods/activate/{id}', 'OrderMethodController@activate');



    Route::resource('paymentmethods', 'PaymentMethodController');
    Route::get('paymentmethods/activate/{id}', 'PaymentMethodController@activate');



    Route::resource('orderstatus', 'OrderStatusController');
    Route::get('orderstatus/activate/{id}', 'OrderStatusController@activate');



    Route::GET('branch/drivers/{branch_id}', 'OrderController@branchDrivers');
    Route::PUT('orders/updateStatus', 'OrderController@update');
    Route::resource('orders','OrderController');

    Route::resource('order_requests','OrderRequestController');
    Route::post('create_order', 'OrderRequestController@createOrder');
});
