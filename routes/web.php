<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('splash');
});
Route::get('/dashboard', function () {
    return view('dashboard/index');
});
Route::get('/leaderboards', function () {
    return view('leaderboards/index');
});
Route::get('/user', function () {
    return view('user/index');
});

Route::get('/login', 'Auth\LoginController@login');

Route::get('/token_exchange', 'Auth\LoginController@tokenexchange');
