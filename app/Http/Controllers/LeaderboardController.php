<?php

namespace App\Http\Controllers;

use NerdRunClub\Calculation;

class LeaderboardController extends Controller
{
    //
    public function index(Calculation $calculation){
        $leaderboards = $calculation->getLeaderboardStats();
        return view('leaderboards/index', ['leaderboard' => $leaderboards]);
    }
}
