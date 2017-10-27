<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Activity;


class UserController extends Controller
{
    //
    public function index(){
        //\NerdRunClub\Request::retrieveActivities();
        $result = Activity::all()->where('user_id', Auth::id());
        $user = Auth::user();
        return view("user.index", ['user' => $user, 'runs' => $result]);
    }
}
