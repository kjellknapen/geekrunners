<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Activity;


class UserController extends Controller
{
    //
    public function index(){
        $result = Activity::all()->where('user_id', Auth::id());
        return view("user.index", ['runs' => $result]);
    }
}
