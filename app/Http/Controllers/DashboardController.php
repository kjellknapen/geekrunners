<?php

namespace App\Http\Controllers;

use App\Activities;
use App\StravaHandler;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(){
        StravaHandler::retrieveActivities();
        $result = Activities::all()->where('user_id', Auth::id());
        return view('dashboard/index', ['runs' => $result]);
    }
}
