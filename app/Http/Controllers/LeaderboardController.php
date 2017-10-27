<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NerdRunClub\Calculations;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Facades\Strava;

class LeaderboardController extends Controller
{
    //
    public function index(){
        $leaderboards = Calculations::getLeaderboardStats();

        $user = Auth::user();

        return view('leaderboards/index', ['leaderboard' => $leaderboards, 'user' => $user]);
    }
}
