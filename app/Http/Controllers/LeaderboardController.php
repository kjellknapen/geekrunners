<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NerdRunClub\Calculation;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Facades\Strava;

class LeaderboardController extends Controller
{
    //
    public function index(){
        $leaderboards = Calculation::getLeaderboardStats();

        return view('leaderboards/index', ['leaderboard' => $leaderboards]);
    }
}
