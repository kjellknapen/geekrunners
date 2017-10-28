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
        $currentWeek = Calculations::currentWeek();
        if($currentWeek != false){
            $event = Calculations::daysLeft();
            return view('dashboard/index', ['event' => $event, 'userStats' => Calculations::getUserStats(), 'topRunners' => $topRunners['Kilometers'], 'scheduleData' => Calculations::getScheduleData($currentWeek)]);
        }
        return view('dashboard.index', ['userStats' => Calculations::getUserStats(), 'topRunners' => $topRunners['Kilometers']]);
    }
}
