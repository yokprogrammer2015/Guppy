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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

# Permission
Route::post('login', 'PermissionController@checkLogin');

Route::get('logout', 'PermissionController@logout');

Route::group(['middleware' => 'my_auth'], function () {

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