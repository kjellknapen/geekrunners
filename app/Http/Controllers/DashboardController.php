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
            // Check the week we are in now
            $currentWeek = $calculations->currentWeek();
            // Calculate the days that are left until the event
            $event = $calculations->daysLeft();
            
            // Get the events name
            $eventName = Event::take(1)->pluck('name');
            return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event,'weekTree' => $calculations->weeklyGoalsTree(Auth::user(), $currentWeek),  'userStats' => $calculations->getUserStats(), 'endDate' => $calculations->getEndDate(), "today" => Carbon::now(), 'topRunners' => $topRunners['Kilometers'], 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
        }
        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
