<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Activity;
use NerdRunClub\Calculations;


class UserController extends Controller
{
    //
    public function index(){
        $result = Activity::take(5)->where('user_id', Auth::id())->get();

        $user = Auth::user();
        return view("user.index", ['user' => $user, 'runs' => $result]);
    }
}
