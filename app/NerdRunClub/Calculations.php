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
use App\Schedules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calculations
{
    protected static $end_date;

    /**
     * @return mixed
     */
    public static function getEndDate()
    {
        return self::$end_date;
    }

    /**
     * @param mixed $end_date
     */
    public static function setEndDate($end_date)
    {
        self::$end_date = $end_date;
    }

    public static function getUserStats(){
        $result = Activity::all()->where('user_id', Auth::id());

        $dt = Carbon::now();
        self::setEndDate(Carbon::create('2018', '04', '22'));
        $interval = $dt->diff(self::getEndDate());
        $daysLeft = $interval->format('%a');

        $weeklyGoal =  9;
        $weeklyDone = 0;
        $remaining = $weeklyGoal;

        foreach ($result as $activity){

            $Date = mb_substr($activity->date, 0, 10);
            $FirstDay = new Carbon('sunday last week');
            $LastDay = new Carbon('sunday this week');

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

    public static function getLeaderboardStats(){
        //$result = User::all()->where('user_id', Auth::id());

        $users = User::all();
        $idAndWeeklyKmArray = [];
        $idAndWeeklyTimeArray = [];

        foreach ($users as $user){

            $totalkm = 0;
            $totaltime = 0;
            $fastesttime = 0;
            $longestrun = 0;
            foreach ($user->activities as $activity){
                $Date = mb_substr($activity->date, 0, 10);
                $FirstDay = new Carbon('sunday last week');
                $LastDay = new Carbon('sunday this week');

                if($Date > $FirstDay && $Date < $LastDay) {
                    $totalkm += $activity->km;
                    $totaltime += $activity->minutes;
                }

                $idAndWeeklyKmArray[$user->id] = $totalkm;
                $idAndWeeklyTimeArray[$user->id] = $totaltime;
            }
        }

        arsort($idAndWeeklyKmArray);
        arsort($idAndWeeklyTimeArray);
        $resultKM = $idAndWeeklyKmArray;
        $resultTime = $idAndWeeklyTimeArray;
        $leaderboardArray = [
            'Kilometers' => [],
            'Time' =>[]
        ];
        foreach ($resultKM as $key=>$value){
            array_push($leaderboardArray['Kilometers'], [
                'user' => User::find($key),
                'km' => $value,
            ]);
        }

        foreach ($resultTime as $key=>$value){
            array_push($leaderboardArray['Time'], [
                'user' => User::find($key),
                'time' => $value,
            ]);
        }
        return $leaderboardArray;
    }

    public static function getScheduleData(){
      /*
      $week="1";
      $duration_goal="20";
      $frequency_goal="2";
      $distance_goal="8";
      */

      $schedules = Schedules::all()->where('id', rand(1,25));

      foreach ($schedules as $schedule) {
        $week = $schedule->week;
        $duration_goal= $schedule->duration_goal;
        $frequency_goal= $schedule->frequency_goal;
        $distance_goal= $schedule->distance_goal;
      }


      $scheduleData = [
        'week'=>$week,
        'duration_goal'=>$duration_goal,
        'frequency_goal'=>$frequency_goal,
        'distance_goal'=>$distance_goal,
      ];

      return $scheduleData;
    }
}
