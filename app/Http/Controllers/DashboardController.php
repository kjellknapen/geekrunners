<?php

namespace App\Http\Controllers;

use App;
use NerdRunClub\Calculation;

class DashboardController extends Controller
{
    //

    public function index(Calculation $calculations){
        $topRunners = $calculations->getLeaderboardStats();

        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
            $currentWeek = $calculations->currentWeek();
            $event = $calculations->daysLeft();
            return view('dashboard/index', ['event' => $event, 'userStats' => $calculations->getUserStats(), 'topRunners' => $topRunners['Kilometers'], 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
        }
        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers']]);
    }
}
