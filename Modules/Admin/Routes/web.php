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

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminLoginController@login')->name('admin.login.submit');
    Route::get('/dashboard', 'AdminModuleController@dashboard')->name('admin.dashboard');
    Route::get('/profile', 'AdminLoginController@EditProfile');
    Route::post('/profile', 'AdminLoginController@updateProfile');
    Route::get('/logout', 'AdminLoginController@logout')->name('admin.logout');



    Route::post('/updateCardStatus', 'AdminController@updateCardStatus')->name('admin.updateCardStatus');


    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::resource('admins', 'AdminController');
    Route::get('admins/activate/{id}', 'AdminController@activate');




    Route::resource('roles', 'RoleController');

    Route::get('/clinetReport', 'ClientReportController@clinetReport')->name('reports.clients');
    Route::get('/clinetChart', 'ClientReportController@clinetChart');

    Route::get('/driverReport', 'DriverReportController@driverReport')->name('reports.drivers');
    Route::get('/driverChart', 'DriverReportController@driverChart');


    Route::get('/productReport', 'TopProductController@productReport')->name('reports.products');

    Route::get('/categoriesReport', 'TopCategoryController@categoryReport')->name('reports.categories');

    Route::get('/branchesReport', 'TopBranchController@branchesReport')->name('reports.branches');

    Route::get('/export/excel', 'OrdersReportController@exportExcel')->name('excel.export')->withoutMiddleware('prevent-back-history');
    Route::get('/ordersReport', 'OrdersReportController@ordersReport')->name('reports.ordersReport');
});
