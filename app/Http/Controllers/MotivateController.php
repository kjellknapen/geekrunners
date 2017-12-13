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
                
                return view('motivate', ['userStats' => $calculations->getUserStats(), 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }
        }


        return view('motivate', ['empty' => true]);
    }

}
