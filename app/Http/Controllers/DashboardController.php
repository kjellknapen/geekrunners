<?php

namespace App\Http\Controllers;

use App\Activities;
use App\StravaHandler;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class DashboardController extends Controller
{
    //

    public function index(){
        StravaHandler::retrieveActivities();
        $result = Activities::all()->where('user_id', Auth::id());


        $year = '2017';
        $month = '04';
        $day = '22';
        $current_date = new DateTime(date('Y-m-d'), new DateTimeZone('Europe/Brussels'));
        $end_date = new DateTime("$year-$month-$day", new DateTimeZone('Europe/Brussels'));
        $interval = $current_date->diff($end_date);
        $daysLeft = $interval->format('%a');

        $weeklyGoal =  '9';
        $weeklyDone = 0;
        $remaining = $weeklyGoal;

        foreach ($result as $activity){

            $Date = str_replace('/', '-', mb_substr($activity->date, 0, 10));
            $FirstDay = date("d-m-Y", strtotime('sunday last week'));
            $LastDay = date("d-m-Y", strtotime('sunday this week'));

            if($Date > $FirstDay && $Date < $LastDay) {
                $weeklyDone += $activity->km;
            }
        }

        $remaining -= $weeklyDone;

        //dd($result);

        return view('dashboard/index', ['daysLeft' => $daysLeft, 'remaining' => $remaining, 'weeklyGoal' => $weeklyGoal, 'weeklyDone' => $weeklyDone]);
    }
}
