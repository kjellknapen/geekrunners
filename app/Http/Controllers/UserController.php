<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\StravaHandler;
use App\Activities;


class UserController extends Controller
{
    //
    public function index(){
        StravaHandler::retrieveActivities();
        $result = Activities::all()->where('user_id', Auth::id());

        $user = Auth::user();
        return view("user.index", ['user' => $user, 'runs' => $result]);
    }
}
