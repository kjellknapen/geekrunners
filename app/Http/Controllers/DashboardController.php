<?php

namespace App\Http\Controllers;

use App\Activity;
use App\NerdRunClub\Strava;
use App\User;
use App;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
use NerdRunClub\Calculations;

class DashboardController extends Controller
{
    //

    public function index(){
        $topRunners = Calculations::getLeaderboardStats();
        $user = Auth::user();

        return view('dashboard/index', ['user' => $user, 'userStats' => Calculations::getUserStats(), 'topRunners' => $topRunners['Kilometers']]);
    }
}
