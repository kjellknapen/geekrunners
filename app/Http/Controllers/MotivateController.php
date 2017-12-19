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
            if($currentWeek < count(Schedules::all()) && $currentWeek > 0){
                
                return view('motivate', ['userStats' => $calculations->getUserStats(), 'scheduleData' => $calculations->getScheduleData($currentWeek)]);
            }
        }


        return view('motivate', ['empty' => true]);
    }
    
    public function motivate(Calculation $calculations){
        try{
            $statusCode = 200;
            $response = [
                'week' => "",
                'avg_duration' => "",
                'frequency_goal' => "",
                'distance_warmup' => "",
                'distance_goal' => "",
                'users_completed' => [],
            ];

            if($calculations->getEndDate() != false || $calculations->getEndDate() != null) {
                $currentWeek = $calculations->currentWeek();
                if ($currentWeek < count(Schedules::all())) {
                    $scheduleData = $calculations->getScheduleData($currentWeek);
                    $response = [
                        'week' => $scheduleData['week'],
                        'avg_duration' => $scheduleData['avg_duration'],
                        'frequency_goal' => $scheduleData['frequency_goal'],
                        'distance_warmup' => $scheduleData['distance_warmup'],
                        'distance_goal' => $scheduleData['distance_goal'],
                        'users_completed' => $scheduleData['users_completed'],
                    ];
                }
            }



        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }
    }

}
