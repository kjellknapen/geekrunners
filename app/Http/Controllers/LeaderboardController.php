<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NerdRunClub\Calculations;

class LeaderboardController extends Controller
{
    //
    public function index(){
        $leaderboards = Calculations::getLeaderboardStats();
        return view('leaderboards/index', ['leaderboard' => $leaderboards]);
    }
}
