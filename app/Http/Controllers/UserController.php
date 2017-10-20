<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use NerdRunClub\Calculations;
use NerdRunClub\Facades\Strava;


class UserController extends Controller
{
    //
    public function index(){
        Calculations::retrieveActivities();
        $result = Activity::all()->where('user_id', Auth::id());

        $user = Auth::user();
        return view("user.index", ['user' => $user, 'runs' => $result]);
    }
}
