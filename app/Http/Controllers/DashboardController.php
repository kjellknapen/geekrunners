<?php

namespace App\Http\Controllers;

use App;
use App\Activity;
use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Calculation;

class DashboardController extends Controller
{
    //

    public function index(Calculation $calculations){
        $topRunners = $calculations->getLeaderboardStats();
        $activityfeed = Activity::orderBy('date','DESC')->take(5)->get();

        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
            if ($calculations->currentWeek()>0) {
              $currentWeek = $calculations->currentWeek();
              $event = $calculations->daysLeft();
              $eventName = Event::take(1)->pluck('name');
              return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event,
              'weekTree' => $calculations->weeklyGoalsTree($currentWeek),  'userStats' => $calculations->getUserStats(), 'topRunners' => $topRunners['Kilometers']
              ,'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }
        }
        if ($calculations->currentWeek()<=0) {
          return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed,'patience'=>true]);
        }
        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
