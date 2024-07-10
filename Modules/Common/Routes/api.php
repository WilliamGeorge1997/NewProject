<?php

use Illuminate\Http\Request;
use Modules\Common\Http\Controllers\api\CommonController;
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

Route::get('/terms/{lang}',  [CommonController::class, 'terms']);
Route::get('/privacy/{lang}',  [CommonController::class, 'privacy']);
Route::get('/refund/{lang}',  [CommonController::class, 'refund']);

Route::get('/deliveryFees',  [CommonController::class, 'deliveryFees']);
Route::get('/tax',  [CommonController::class, 'tax']);

Route::get('/about/{lang}',  [CommonController::class, 'about']);
Route::get('/delivery_text/{lang}',  [CommonController::class, 'delivery_text']);

Route::get('/sliders',  [CommonController::class, 'sliders']);

Route::get('contactData',  [CommonController::class, 'contactData']);

Route::post('/contactUs',  [CommonController::class, 'contactUs']);


Route::group([
    'namespace' => 'api'
], function ($router) {

    Route::get('cities', 'CityController@index');
});
