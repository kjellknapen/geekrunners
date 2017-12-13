<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventWinners;
use App\Schedules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Calculation;

class MotivateController extends Controller
{

    public function index(Calculation $calculations) {


        // Check if an enddate is set
        if($calculations->getEndDate() != false || $calculations->getEndDate() != null){
            $today = Carbon::now();
            $enddate = $calculations->getEndDate();
            $diff = $today->diffInDays($enddate);
            //load the weektree & weekly goals
            $currentWeek = $calculations->currentWeek();
            if($currentWeek < count(Schedules::all())){
                $event = $calculations->daysLeft();
                $eventName = Event::take(1)->pluck('name');
                return view('motivate', ['eventName'=> $eventName, 'event' => $event,'weekTree' => $calculations->weeklyGoalsTree(Auth::user(), $currentWeek),  'userStats' => $calculations->getUserStats(), 'D_Day' => false,
                     'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }else{
                $event = $calculations->daysLeft();
                $eventName = Event::take(1)->pluck('name');
                $winners = EventWinners::all();
                return view('motivate', ['eventName'=> $eventName, 'event' => $event, 'D_Day' => true, 'diff' => $diff,
                    'topthreedday' => $winners]);
            }
        }


        return view('motivate', ['empty' => true]);
    }

}
