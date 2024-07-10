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

// Route::middleware('auth:api')->get('/provider', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'provider/auth',
    'namespace' => 'api'

], function ($router) {

    Route::post('login', 'ProviderAuthController@login');
    Route::post('verify', 'ProviderAuthController@verifyOtp');
    Route::post('logout', 'ProviderAuthController@logout');
    Route::post('refresh', 'ProviderAuthController@refresh');
    Route::post('me', 'ProviderAuthController@me');



    Route::post('forgetPassword', 'ProviderAuthController@forgetPassword');
    Route::post('verifyForgetPassword', 'ProviderAuthController@verifyForgetPassword');
    Route::post('newPassword', 'ProviderAuthController@newPassword');
});



Route::group([
    'namespace' => 'api'
], function ($router) {

    Route::group(['prefix' => 'provider'], function ($router) {
        Route::post('/activate/{id}','ProviderController@activate');
    });
    Route::post('provider/services','ProviderController@StoreServices');
    Route::get('provider/sub_services','ProviderController@sub_services');
    Route::post('provider/times','ProviderController@StoreTimes');
    Route::get('nearbyProviders','ProviderController@NearbyProviders');
    Route::get('sliderProviders','ProviderController@SliderProviders');
    Route::get('provider/servicesWithSubServices','ProviderController@servicesWithSubServices');
    Route::get('provider/{provider_id}/services/sub_services','ProviderController@providerServicesWithSubServices');
    Route::get('provider/{provider_id}/images','ProviderController@providerImages');
    Route::get('provider/images','ProviderController@providerAuthImages');
    Route::get('provider/{provider_id}/rates','ProviderController@providerRates');
    Route::get('provider/{provider_id}/employees','ProviderController@providerEmployees');
    Route::get('provider/{provider_id}/packages','ProviderController@providerPackages');
    Route::get('providerData','ProviderController@providerData');
    Route::post('provider/saveWorkImages','ProviderController@addWorkImages');
    Route::post('provider/update','ProviderController@updateAuthProvider');
    Route::delete('provider/deleteWorkImage/{image_id}','ProviderController@deleteWorkImage');
    Route::resource('provider','ProviderController');
});
