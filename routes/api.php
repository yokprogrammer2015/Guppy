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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Amphure
Route::get('amphure/{id}', 'AjaxController@getAmphure');

# District
Route::get('district/{id}', 'AjaxController@getDistrict');

# Service
Route::get('dailySale', 'ServiceController@dailySale');

# Config
Route::get('agent', 'ApiController@agent');

Route::get('branch', 'ApiController@branch');

Route::get('route', 'ApiController@route');

Route::get('time', 'ApiController@time');

Route::get('bank', 'ApiController@bank');