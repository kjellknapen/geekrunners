<?php

namespace App\Http\Controllers;

use App;
use NerdRunClub\Calculation;

class DashboardController extends Controller
{
    //

    public function index(){
        $topRunners = Calculation::getLeaderboardStats();
        $currentWeek = Calculation::currentWeek();
        if($currentWeek != false){
            $event = Calculation::daysLeft();
            return view('dashboard/index', ['event' => $event, 'userStats' => Calculation::getUserStats(), 'topRunners' => $topRunners['Kilometers'], 'scheduleData' => Calculation::getScheduleData($currentWeek)]);
        }
        return view('dashboard.index', ['userStats' => Calculation::getUserStats(), 'topRunners' => $topRunners['Kilometers']]);
    }
}
