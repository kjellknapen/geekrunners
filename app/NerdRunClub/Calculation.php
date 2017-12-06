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

    // Calculate the days that are left
    public function daysLeft(){
        $dt = Carbon::now();
        self::setEndDate();
        $interval = $dt->diff(self::getEndDate());
        $daysLeft = $interval->format('%a');

        return $daysLeft;
    }

    // Save the medals at the end of the week
    public function saveMedals(){
        $leaderboards = $this->getLeaderboardStats();

        $id = $leaderboards['Kilometers'][0]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals1;
        $user->medals1 = $currentMedals + 1;
        $user->save();

        $id = $leaderboards['Kilometers'][1]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals2;
        $user->medals2 = $currentMedals + 1;
        $user->save();

        $id = $leaderboards['Kilometers'][2]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals3;
        $user->medals3 = $currentMedals + 1;
        $user->save();

        //

        $id = $leaderboards['Time'][0]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals1;
        $user->medals1 = $currentMedals + 1;
        $user->save();

        $id = $leaderboards['Time'][1]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals2;
        $user->medals2 = $currentMedals + 1;
        $user->save();

        $id = $leaderboards['Time'][2]['user']['id'];
        $user = User::find($id);
        $currentMedals = $user->medals3;
        $user->medals3 = $currentMedals + 1;
        $user->save();

    }

    // Get the current week
    public function currentWeek()
    {
        $dt = Carbon::now();
        $this->setStartDate();
        $startdate = $this->getStartDate();
        $interval = $dt->diffInWeeks($this->getStartDate());
        $weekNumber = $interval + 1;
        if ($dt<$startdate) {
          //Goshdarn time travellers
          $weekNumber = -$weekNumber;
        }
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

                    $idAndWeeklyKmArray[$user->id] = $totalkm;
                    $idAndWeeklyTimeArray[$user->id] = $totaltime;
                }
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

        $result = $this->userScheduleDate(Auth::user(), $distance_goal, $frequency_goal, $duration_goal);
        $users_completed = [];
        foreach (User::all() as $user){
            $usersresults = $this->userScheduleDate($user, $distance_goal, $frequency_goal, $duration_goal);
            if($usersresults['duration_progress'] >= 100 && $usersresults['frequency_progress'] >= 100 && $usersresults['distance_progress'] >= 100){
                array_push($users_completed, $user);
            }
        }

        $scheduleData = [
            'week'=>$week,
            'duration_goal'=>$duration_goal,
            'duration_completed'=>$result['duration_progress'],
            'frequency_goal'=>$frequency_goal,
            'frequency_completed'=>$result['frequency_progress'],
            'distance_goal'=>$distance_goal,
            'distance_completed'=>$result['distance_progress'],
            'users_completed'=>$users_completed,
        ];

        return $scheduleData;
    }

    public function userScheduleDate($user, $distance, $frequency, $duration){
        $runs = 0;
        $minutes = 0;
        $longest = 0;
        foreach ($user->activities as $activity){
            $Date = mb_substr($activity->date, 0, 10);
            $FirstDay = new Carbon('sunday last week');
            $LastDay = new Carbon('sunday this week');
            if($Date > $FirstDay && $Date < $LastDay) {
                $runs += 1;
                $minutes += $activity->minutes;
                if($activity->km > $longest){
                    $longest = $activity->km;
                }
            }
        }

        $distance_progress = round(($longest !== 0 ? ($longest / $distance) : 0) * 100);
        $duration_progress = round(($minutes !== 0 ? ($minutes / $duration) : 0) * 100);
        $frequency_progress = round(($runs !== 0 ? ($runs / $frequency) : 0) * 100);

        return $result = [
          'distance_progress' => $distance_progress,
          'frequency_progress' => $frequency_progress,
          'duration_progress' => $duration_progress
        ];
    }

    public function achievementsDone(){

    }

    public function achievementsTodo(){

    }

    //check The schedules and calculate if you completed them.
    public function weeklyGoalsTree($user, $currentweek){
        $schedules = Schedules::all();
        $activities = $user->activities;
        $date = $this->getStartDate()->toDateTimeString();
        $carbonStartDate = new Carbon($date);
        $carbonEndDate = new Carbon($date);

        // Loop true schedules
        $weekTree = [];
        $startdate = $carbonStartDate->startOfWeek()->subDay(1);
        $enddate = $carbonEndDate->endOfWeek();
        $addDaysStart = 0;
        $addDaysEnd = 0;

        foreach($schedules as $schedule){
            //Calculate only for the weeks before current week and current week
            $distance_progress = false;
            $duration_progress = false;
            $frequency_progress = false;

            $runs = 0;
            $minutes = 0;
            $longest = 0;
            if($schedule->id <= $currentweek){
                $startdate->addDays($addDaysStart);
                $enddate->addDays($addDaysEnd);
                foreach ($activities as $activity){
                    $activityDate = new Carbon($activity->date);

                    if($activityDate > $startdate && $activityDate < $enddate){
                        $runs += 1;
                        $minutes += $activity->minutes;
                        if($activity->km > $longest){
                            $longest = $activity->km;
                        }
                    }
                }
                $distance_progress = round(($longest !== 0 ? ($longest / $schedule->distance_goal) : 0) * 100);
                $duration_progress = round(($minutes !== 0 ? ($minutes / $schedule->duration_goal) : 0) * 100);
                $frequency_progress = round(($runs !== 0 ? ($runs / $schedule->frequency_goal) : 0) * 100);
            }
            if($duration_progress >= 100 && $frequency_progress >= 100 && $distance_progress >= 100){
                $weekTree[$schedule->id] = "completed";
            }elseif($duration_progress === false && $distance_progress === false && $frequency_progress === false || $schedule->id === $currentweek){
                $weekTree[$schedule->id] = "inprogress";
            }elseif($duration_progress < 100 || $frequency_progress < 100 || $distance_progress < 100){
                $weekTree[$schedule->id] = "failed";
            }
            $addDaysStart = 7;
            $addDaysEnd = 7;
        }
        return $weekTree;
    }
}
