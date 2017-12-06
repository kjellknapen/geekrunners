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
        //Check for startdate, necessary for loading in scheduletree en weekly goals.
        if ($calculations->getStartDate() == null || $calculations->getStartDate() == false) {
          return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
        };
        //check for negative current week. Have patience young grasshopper, the training will soon commence.
        if ($calculations->currentWeek()<=0) {
            return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed,'patience'=>true]);
          }

        // Check if an enddate is set
        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
              //load the weektree & weekly goals
              $currentWeek = $calculations->currentWeek();
              $event = $calculations->daysLeft();
              $eventName = Event::take(1)->pluck('name');
              return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event,'weekTree' => $calculations->weeklyGoalsTree(Auth::user(), $currentWeek),  'userStats' => $calculations->getUserStats(), 'endDate' => $calculations->getEndDate(), "today" => Carbon::now(),
             'topRunners' => $topRunners['Kilometers'], 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
        }

        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
