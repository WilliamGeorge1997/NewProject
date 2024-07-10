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

// Route::prefix('client')->group(function() {
//     Route::get('/', 'ClientController@index');
// });

Route::prefix('admin')->group(function() {

    Route::resource('clients','ClientController');
    Route::get('clients/activate/{id}','ClientController@activate');
    Route::get('balances','BalanceTransactionController@index')->name('balances.index');

});
