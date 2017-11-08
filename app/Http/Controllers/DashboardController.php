<?php

namespace App\Http\Controllers;

use App;
use App\Activity;
use App\Event;
use NerdRunClub\Calculation;

class DashboardController extends Controller
{
    //

    public function index(Calculation $calculations){
        $topRunners = $calculations->getLeaderboardStats();
        $activityfeed = Activity::take(5)->get();


        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
            $currentWeek = $calculations->currentWeek();
            $event = $calculations->daysLeft();
            $eventName = Event::take(1)->pluck('name');
            return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event, 'userStats' => $calculations->getUserStats(), 'topRunners' => $topRunners['Kilometers'], 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
        }
        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
