<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 18.10.17
 * Time: 10:31
 */

namespace NerdRunClub;

use App\Activity;
use App\Event;
use App\User;
use App\Schedules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calculation
{
    protected $end_date;
    protected $start_date;

    public function __construct()
    {
        $this->setEndDate();
        $this->setStartDate();
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate()
    {
        $event = Event::all()->where('id', 1)->first();
        if (!empty($event)) {
            $this->start_date = Carbon::createFromFormat("Y-m-d", $event->start_date);
        }else{
            $this->start_date = false;
        }
    }
    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate()
    {
        $event = Event::all()->where('id', 1)->first();
        if (!empty($event)) {
            $this->end_date = Carbon::createFromFormat("Y-m-d", $event->event_date);
        }else{
            $this->end_date = false;
        }
    }
    
    public function daysLeft(){
        $dt = Carbon::now();
        self::setEndDate();
        $interval = $dt->diff(self::getEndDate());
        $daysLeft = $interval->format('%a');

        return $daysLeft;
    }

    public function saveMedals(){
        $leaderboards = $this->getLeaderboardStats();

        $topKilometers = array_slice($leaderboards['Kilometers'], 0, 5, true);
        foreach ($topKilometers as $i){
            $id = $i['user']['id'];
            $user = User::find($id);
            $currentMedals = $user->medals;
            $user->medals = $currentMedals + 1;
            $user->save();
        }

        $topTime = array_slice($leaderboards['Time'], 0, 5, true);
        foreach ($topTime as $i){
            $id = $i['user']['id'];
            $user = User::find($id);
            $currentMedals = $user->medals;
            $user->medals = $currentMedals + 1;
            $user->save();
        }
    }

    public function currentWeek()
    {
        $dt = Carbon::now();
        $this->setStartDate();
        $interval = $dt->diffInWeeks($this->getStartDate());
        $weekNumber = $interval + 1;

        return $weekNumber;
    }

    public function getUserStats(){
        $result = Activity::all()->where('user_id', Auth::id());

        $dt = Carbon::now();
        self::setEndDate();
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

    public function getLeaderboardStats(){
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

    public function getScheduleData($weekID){
      /*
      $week="1";
      $duration_goal="20";
      $frequency_goal="2";
      $distance_goal="8";
      */

      $schedules = Schedules::all()->where('id', $weekID);

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
