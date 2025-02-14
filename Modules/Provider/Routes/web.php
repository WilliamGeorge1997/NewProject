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

Route::prefix('provider')->group(function() {
    Route::get('/', 'ProviderController@index');
});

Route::prefix('admin')->group(function() {
    Route::resource('providers','ProviderController');
    Route::get('providers/activate/{id}', 'ProviderController@activate');

});
