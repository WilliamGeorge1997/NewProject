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

// Route::prefix('notification')->group(function() {
//     Route::get('/', 'NotificationController@index');
// });


Route::prefix('admin')->group(function() {
    Route::get('city/clients/{id?}', 'NotificationController@getCityClients');
    Route::resource('notifications','NotificationController');
    Route::get('notification/read/{id}','NotificationController@readNotification');

});
