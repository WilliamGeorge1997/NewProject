<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/order', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'namespace' => 'api'
], function ($router) {

    Route::get('orderMethods', 'orderMethodsController@index');
    Route::get('paymentMethods', 'paymentMethodsController@index');
    Route::get('order_statuses', 'orderStatusController@index');

    Route::resource('orders', 'orderController');
    Route::post('order/{id}/updateDetails', 'orderDetailsController@store');
    Route::post('order/deleteDetails/{id}', 'orderDetailsController@destroy');

    Route::get('order/{id}/history', 'orderController@orderHistory');
    Route::get('order/{id}/track', 'orderController@orderTrack');

    Route::post('order/rate', 'rateController@store');


    Route::post('checkOrderCreationAvailability', 'orderController@checkOrderCreationAvailability');

    Route::post('order/{id}/cancel', 'orderController@cancel');


    Route::resource('order_requests', 'orderRequestController');
    Route::post('order_request/{id}/cancel', 'orderRequestController@cancel');

});
