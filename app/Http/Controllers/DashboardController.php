<?php

namespace App\Http\Controllers;

use App\Activity;
use App\NerdRunClub\Strava;
use App\User;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class DashboardController extends Controller
{
    //

    public function index(){

//        $users = User::find(1);
//        dd($users->firstname);

        $topRunners = $this->getTopRunners();
        $topRunnersResult = [];
        foreach ($topRunners as $key=>$value){
            array_push($topRunnersResult, [
                'user' => User::find($key),
                'km' => $value,
            ]);
        }

        //dd($topRunnersResult);

        return view('dashboard/index', ['userStats' => $this->getUserStats(), 'topRunners' => $topRunnersResult]);
    }

    function getUserStats(){
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

    function getTopRunners(){
        //$result = User::all()->where('user_id', Auth::id());

        $users = User::all();
        $idAndWeeklyKmArray = [];

        foreach ($users as $user){

            $activities = Activity::all()->where('user_id',$user['id']);
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
        $result = array_slice($idAndWeeklyKmArray,0,3,true);

        return $result;

//        foreach ($result as $key=>$value){
//            dd($value);
//        }

    }

    public function retrieveActivities(){
        $url = 'https://www.strava.com/api/v3/activities/';
        $users = User::all();

        foreach ($users as $u) {
            if(ctype_digit( $u->strava_id )) {
                $token = $u->token;

                $result = Strava::get($url, $token);

                foreach ($result as $run) {
                    $date = strtotime($run->start_date);
                    $check_activities = Activity::all()->where('strava_id', $run->id)->first();
                    if ($check_activities) {
                        // Don't Save
                    } else {
                        Activity::create([
                            'name' => $run->name,
                            'user_id' => $u->id,
                            'strava_id' => $run->id,
                            'map_id' => $run->map->id,
                            'date' => date('d/m/Y H:i:s', $date),
                            'average_speed' => $run->average_speed,
                            'max_speed' => $run->max_speed,
                            'km' => number_format($run->distance / 1000, 2),
                            'minutes' => floor($run->elapsed_time / 60),
                        ]);
                    }
                }
            }
        }
    }
}
