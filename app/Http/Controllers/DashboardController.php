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

    public function index(Calculation $calculations){



        //TEMP






        // Get leaderboard stats
        $topRunners = $calculations->getLeaderboardStats();
        // Activities voor activity feed
        $activityfeed = Activity::orderBy('date','DESC')->take(8)->get();
        //Check for startdate, necessary for loading in scheduletree en weekly goals.
        if ($calculations->getStartDate() == null || $calculations->getStartDate() == false) {
          return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed,'noevent'=>true]);
        };
        //check for negative current week. Have patience young grasshopper, the training will soon commence.
        if ($calculations->currentWeek()<=0) {
            $startdate= $calculations->getStartDate();
            $future = $startdate->format('l d F');
            //dd($startdate);
          return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed,'future'=>$future]);
          }

        // Check if an enddate is set
        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
              $today = Carbon::now();
              $enddate = $calculations->getEndDate();
              $endOfWeek = $enddate->copy()->endOfWeek();
              $diff = $today->diffInDays($enddate);
              //load the weektree & weekly goals
              $currentWeek = $calculations->currentWeek();
            if($currentWeek <= count(App\Schedules::all()) && $enddate->diffInDays($endOfWeek) < $today->diffInDays($endOfWeek)){
              $event = $calculations->daysLeft();
              $diff = $calculations->getStartDate()->diffInDays($endOfWeek);
              $todaydiff = Carbon::now()->diffInDays(Carbon::now()->endOfWeek()) + 1;
              $eventName = Event::take(1)->pluck('name');
              return view('dashboard/index', ['eventName'=> $eventName, 'todayDiff' => $todaydiff, 'activityfeed' => $activityfeed, 'diff' => $diff,'event' => $event,'weekTree' => $calculations->weeklyGoalsTree(Auth::user(), $currentWeek),  'userStats' => $calculations->getUserStats(), 'D_Day' => false,
             'topRunners' => $topRunners['Kilometers'], 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }else{
                $event = $calculations->daysLeft();
                $eventName = Event::take(1)->pluck('name');
                $winners = App\EventWinners::all();
                return view('dashboard/index', ['eventName'=> $eventName, 'activityfeed' => $activityfeed,'event' => $event, 'D_Day' => true, 'diff' => $diff,
                    'topRunners' => $topRunners['Kilometers'], 'topthreedday' => $winners]);
            }
        }









        return view('dashboard.index', ['topRunners' => $topRunners['Kilometers'],'activityfeed' => $activityfeed]);
    }
}
