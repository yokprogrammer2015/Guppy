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

Route::get('/', 'PermissionController@checkLogin');

# Permission
Route::post('login', 'PermissionController@checkLogin');

Route::get('logout', 'PermissionController@logout');

Route::group(['middleware' => 'my_auth'], function () {
# Dash Board
    Route::any('dashboard', 'DashboardController@index');

# Booking
    Route::any('booking/list', 'BookingController@index');

    Route::any('booking/boat/{id?}', 'BookingController@boat');

    Route::any('booking/jointTicket/{id?}', 'BookingController@jointTicket');

    Route::any('booking/bus/{id?}', 'BookingController@bus');

    Route::get('booking/remove/{order_id}', 'BookingController@remove');

    Route::post('booking/save', 'BookingController@save');

# Daily Sale Cash
    Route::any('daily/cash/list', 'DailyCashController@index');

    Route::any('daily/cash/boat', 'DailyCashController@boat');

    Route::any('daily/cash/jointTicket', 'DailyCashController@jointTicket');

    Route::any('daily/cash/bus', 'DailyCashController@bus');

    Route::any('daily/cash/train', 'DailyCashController@train');

    Route::post('daily/cash/save', 'DailyCashController@save');

# Daily Sale Credit
    Route::any('daily/credit/list', 'DailyCreditController@index');

    Route::any('daily/credit/boat', 'DailyCreditController@boat');

    Route::any('daily/credit/jointTicket', 'DailyCreditController@jointTicket');

    Route::any('daily/credit/bus', 'DailyCreditController@bus');

    Route::any('daily/credit/train', 'DailyCreditController@train');

    Route::post('daily/credit/report', 'DailyCreditController@report');

    Route::post('daily/credit/save', 'DailyCreditController@save');

# Invoice
    Route::any('invoice/list', 'InvoiceController@index');

    Route::any('invoice/add', 'InvoiceController@add');

    Route::get('invoice/sendMail/{inv_id}', 'InvoiceController@sendMail');

    Route::post('invoice/save', 'InvoiceController@save');

# Daily Sale Clear Credit
    Route::any('clear/list', 'DailyClearController@index');

    Route::any('clear/cash', 'DailyClearController@cash');

    Route::any('clear/check', 'DailyClearController@check');

    Route::post('clear/save', 'DailyClearController@save');

# Administrator
    Route::get('admin/agent', 'AdminController@agent');

    Route::get('admin/add/agent/{id?}', 'AdminController@addAgent');

    Route::get('admin/member', 'AdminController@member');

    Route::get('admin/add/member/{id?}', 'AdminController@addMember');

    Route::get('admin/logs', 'AdminController@logs');

    Route::post('admin/save/agent', 'AdminController@saveAgent');

    Route::post('admin/save/member', 'AdminController@saveMember');

# Configuration
    Route::get('config/branch', 'ConfigController@branch');

    Route::get('config/add/branch/{id?}', 'ConfigController@addBranch');

    Route::get('config/route', 'ConfigController@route');

    Route::get('config/add/route/{id?}', 'ConfigController@addRoute');

    Route::get('config/destination', 'ConfigController@destination');

    Route::get('config/add/destination/{id?}', 'ConfigController@addDestination');

    Route::get('config/bestSeller', 'ConfigController@bestSeller');

    Route::get('config/add/bestSeller/{id?}', 'ConfigController@addBestSeller');

    Route::get('config/time', 'ConfigController@time');

    Route::get('config/add/time/{id?}', 'ConfigController@addTime');

    Route::get('config/bank', 'ConfigController@bank');

    Route::get('config/add/bank/{id?}', 'ConfigController@addBank');

    Route::get('config/remove/{category}/{id}', 'ConfigController@remove');

    Route::post('config/save', 'ConfigController@save');

    Route::post('config/saveBestSeller', 'ConfigController@saveBestSeller');
# Ajax
    Route::get('ajax/getDestination/{id}', 'AjaxController@getDestination');
});