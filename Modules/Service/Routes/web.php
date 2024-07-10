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

Route::prefix('admin')->group(function() {

    Route::resource('services','ServiceController');
    Route::get('services/activate/{id}','ServiceController@activate');

    Route::resource('sub_services','SubServiceController');
    Route::get('sub_services/activate/{id}','SubServiceController@activate');

});
