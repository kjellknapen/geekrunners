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

    Route::get('/leaderboards', function () {
        return view('leaderboards/index');
    });
    Route::get('/user', 'UserController@index');

});
Route::get('/achievements', 'Achievements@index');


// Reroute if user is loggedin
Route::middleware(['guest'])->group(function () {

    Route::get('/', function () { return view('splash'); });

    Route::get('/login', 'Auth\LoginController@login');

    Route::get('/token_exchange', 'Auth\LoginController@tokenexchange');
});