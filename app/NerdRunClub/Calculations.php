<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 18.10.17
 * Time: 10:31
 */

namespace NerdRunClub;

use App\Activity;
use App\User;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Facades\Strava;
use DateTime;
use DateTimeZone;

class Calculations
{
    public static function getUserStats(){
        $result = Activity::all()->where('user_id', Auth::id());


        $year = '2017';
        $month = '04';
        $day = '22';
        $current_date = new DateTime(date('Y-m-d'), new DateTimeZone('Europe/Brussels'));
        $end_date = new DateTime("$year-$month-$day", new DateTimeZone('Europe/Brussels'));
        $interval = $current_date->diff($end_date);
        $daysLeft = $interval->format('%a');

        $weeklyGoal =  9;
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

        $userStats = [
            'daysLeft' => $daysLeft,
            'weeklyGoal' => $weeklyGoal,
            'weeklyDone' => $weeklyDone,
            'remaining' => $remaining,
        ];

        return  $userStats;
    }

    public static function getTopRunners(){
        //$result = User::all()->where('user_id', Auth::id());

        $users = User::all();
        $idAndWeeklyKmArray = [];

        foreach ($users as $user){

            $activities = Activity::find('1')->user();
            dd($activities);
            $total = 0;
            foreach ($activities as $activity){

                $Date = str_replace('/', '-', mb_substr($activity->date, 0, 10));
                $FirstDay = date("d-m-Y", strtotime('sunday last week'));
                $LastDay = date("d-m-Y", strtotime('sunday this week'));

                if($Date > $FirstDay && $Date < $LastDay) {
                    $total += $activity['km'];
                }

                $idAndWeeklyKmArray[$user['id']] = $total;
            }
        }

        arsort($idAndWeeklyKmArray);
        $result = $idAndWeeklyKmArray;

        $topRunnersResult = [];
        foreach ($result as $key=>$value){
            array_push($topRunnersResult, [
                'user' => User::find($key),
                'km' => $value,
            ]);
        }

        dd($topRunnersResult);
        return $topRunnersResult;

//        foreach ($result as $key=>$value){
//            dd($value);
//        }

    }

    public static function leaderboardTime(){

    }
}