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

// Route::prefix('common')->group(function() {
//     Route::get('/', 'CommonController@index');
// });

Route::prefix('admin')->group(function () {
    Route::get('/setting', 'CommonController@setting')->name('setting.index');
    Route::post('/setting', 'CommonController@savesetting');

    Route::resource('cities','CityController');
    Route::get('cities/activate/{id}','CityController@activate');

    Route::resource('sliders','SliderController');
    Route::get('sliders/activate/{id}','SliderController@activate');

    Route::post('viewOrderNotify', 'CommonController@viewOrderNotify')->name('viewOrderNotify');

    Route::get('/logs', 'CommonController@logs')->name('logs.index');

    Route::get('/test', 'CommonController@test');

});
