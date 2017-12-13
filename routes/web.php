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

// Routes for loggedin users
Route::middleware(['notloggedin'])->group(function () {

    // Routes only for users withouth a student of teacher
    Route::middleware(['roleset'])->group(function () {

        Route::get('/role', 'AdminController@chooseRole');

        Route::post('/role', 'AdminController@saveRole');

    });

    Route::middleware(['rolenotset'])->group(function () {

        Route::get('/dashboard', 'DashboardController@index');

        Route::get('/leaderboard', 'LeaderboardController@index');

        Route::get('/user', 'UserController@index');

        Route::get('/user/{user}', 'UserController@show');

        Route::get('/achievements', 'Achievements@index');

        Route::get('/logout', 'UserController@logout');

        Route::post('/enablemail', 'UserController@enableMail');

        Route::post('/disablemail', 'UserController@disableMail');

    });

    // Routes only for teacher
    Route::middleware(['checkifteacher'])->group(function () {

        Route::get('/admin', 'AdminController@index');

        Route::get('/admin/event', 'AdminController@event');

        Route::post('/admin/event', 'AdminController@saveEvent');

        Route::get('/admin/password', 'AdminController@passwordIndex');

        Route::post('/admin/password', 'AdminController@savePassword');

        Route::get('/admin/winners', 'AdminController@saveWinners');

        Route::post('/admin/winners', 'AdminController@saveWinners');

    });

});


Route::get('/halloffame', 'LeaderboardController@halloffame');


// Reroute if user is loggedin
Route::middleware(['guest'])->group(function () {

    Route::get('/', function () { return view('splash'); });

    Route::get('/login', 'Auth\LoginController@login');

    Route::get('/token_exchange', 'Auth\LoginController@tokenexchange');
});
