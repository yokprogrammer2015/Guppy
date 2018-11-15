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

Auth::routes();

Route::get('/', 'HomeController@index');

# Home
Route::any('guppy/list', 'HomeController@index');

Route::get('admin', 'PermissionController@checkLogin');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

# Booking
Route::post('booking/detail', 'BookingController@bookingDetail');

Route::post('booking/save', 'BookingController@save');

# Contact
Route::get('payment', 'ContactController@payment');

Route::post('payment/save', 'ContactController@save');

# Permission
Route::post('login', 'PermissionController@checkLogin');

Route::any('logout', 'PermissionController@logout');

Route::group(['middleware' => 'my_auth'], function () { // Back End
# Booking
    Route::any('payment/list', 'PaymentController@index');

    Route::get('payment/add/{id?}', 'PaymentController@add');

    Route::get('payment/remove/{id?}', 'PaymentController@remove');

    Route::post('payment/save', 'PaymentController@save');

# Order
    Route::any('order/list', 'OrderController@index');

    Route::any('order/guppy/{id?}', 'OrderController@guppy');

    Route::get('order/remove/{id}', 'OrderController@remove');

    Route::post('order/save', 'OrderController@save');

# Administrator
    Route::get('admin/agent', 'AdminController@agent');

    Route::get('admin/add/agent/{id?}', 'AdminController@addAgent');

    Route::get('admin/member', 'AdminController@member');

    Route::get('admin/add/member/{id?}', 'AdminController@addMember');

    Route::get('admin/logs', 'AdminController@logs');

    Route::post('admin/save/agent', 'AdminController@saveAgent');

    Route::post('admin/save/member', 'AdminController@saveMember');

# Configuration
    Route::any('config/category', 'ConfigController@category');

    Route::get('config/add/category/{id?}', 'ConfigController@addCategory');

    Route::any('config/bank', 'ConfigController@bank');

    Route::get('config/add/bank/{id?}', 'ConfigController@addBank');

    Route::post('config/save', 'ConfigController@save');

    Route::get('config/remove/{category}/{id}', 'ConfigController@remove');
# Ajax
    Route::get('ajax/getDestination/{id}', 'AjaxController@getDestination');
});