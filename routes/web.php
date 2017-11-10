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

    Route::get('/dashboard', 'DashboardController@index');

    Route::get('/leaderboard', 'LeaderboardController@index');

    Route::get('/user', 'UserController@index');

    Route::get('/achievements', 'Achievements@index');

    Route::get('/logout', 'UserController@logout');

    // Routes only for users withouth a student of teacher
    Route::middleware(['nojob'])->group(function () {

        Route::get('/job', 'AdminController@chooseJob');

        Route::post('/job', 'AdminController@saveJob');

    });

    // Routes only for teacher
    Route::middleware(['checkifteacher'])->group(function () {

        Route::get('/admin', 'AdminController@index');

        Route::post('/admin', 'AdminController@saveshedule');

        Route::get('/admin/event', 'AdminController@setCurrentEvent');

        Route::post('/admin/event', 'AdminController@saveEvent');
    });

});


// Reroute if user is loggedin
Route::middleware(['guest'])->group(function () {

    Route::get('/', function () { return view('splash'); });

    Route::get('/login', 'Auth\LoginController@login');

    Route::get('/token_exchange', 'Auth\LoginController@tokenexchange');
});
