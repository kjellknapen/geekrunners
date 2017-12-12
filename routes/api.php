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

Route::get('/users', 'Api\UserApiController@index');

Route::get('/users/{id}', 'Api\UserApiController@findById');

Route::get('/schedules', 'Api\ScheduleController@index');

Route::post('/schedules/calculate', 'Api\ScheduleController@calculate');

Route::get('/schedules/{id}', 'Api\ScheduleController@findById');