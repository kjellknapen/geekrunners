<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NerdRunClub\Calculations;

class LeaderboardController extends Controller
{
    //
    public function index(){
        $runners = Calculations::getTopRunners();
        return view('leaderboards/index', ['km' => $runners]);
    }
}
