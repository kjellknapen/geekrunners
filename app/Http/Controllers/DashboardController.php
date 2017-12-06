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
        // Get leaderboard stats
        $topRunners = $calculations->getLeaderboardStats();
        // Activities voor activity feed
        $activityfeed = Activity::orderBy('date','DESC')->take(5)->get();

        // Check if an enddate is set
        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
            //Check for early birds who want to train before the startdate
            if ($calculations->currentWeek()>0) {
              //load the weektree & weekly goals
              $currentWeek = $calculations->currentWeek();
              $event = $calculations->daysLeft();
              $eventName = Event::take(1)->pluck('name');
              return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event,
              'weekTree' => $calculations->weeklyGoalsTree($currentWeek),  'userStats' => $calculations->getUserStats(), 'topRunners' => $topRunners['Kilometers']
              ,'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }
        }
        //Be patient young grasshopper, send out a notice that the training will soon commence.
        if ($calculations->currentWeek()<=0) {
          return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed,'patience'=>true]);
        }
        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
