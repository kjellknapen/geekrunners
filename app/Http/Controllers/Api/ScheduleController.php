<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Schedules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use NerdRunClub\ScheduleCalculations;
use Psy\Util\Json;

class ScheduleController extends Controller
{
    //
    public function index(){
        try{
            $statusCode = 200;
            $response = [
                'Schedules'  => []
            ];

            $schedules = Schedules::all();

            foreach($schedules as $schedule){

                $response['Schedules'][] = [
                    'id' => $schedule->id,
                    'week' => $schedule->week,
                    'set' => $schedule->set,
                    'duration_goal' => $schedule->duration_goal,
                    'distance_goal' => $schedule->distance_goal,
                    'distance_warmup' => $schedule->distance_warmup,
                    'frequency_goal' => $schedule->frequency_goal,
                ];
            }

        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }

    }

    public function calculate(Request $request){
        try{
            $statusCode = 200;
            $response = [
                'Schedules'  => []
            ];

            $startdate = Carbon::createFromTimestamp($request->input('startdate'));
            $enddate = Carbon::createFromTimestamp($request->input('enddate'));
            $distance = $request->input('distance');

            $calc = new ScheduleCalculations($startdate, $enddate, $distance);
            $schedules = $calc->create_schedule();
            
            foreach($schedules as $schedule){

                $response['Schedules'][] = [
                    'week' => $schedule->week,
                    'set' => $schedule->set,
                    'duration_goal' => $schedule->duration_goal,
                    'distance_goal' => $schedule->distance_goal,
                    'distance_warmup' => $schedule->distance_warmup,
                    'frequency_goal' => $schedule->frequency_goal,
                ];
            }

        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }
    }


    public function findById($id){
        try{
            $statusCode = 200;
            $response = [
                'Schedule'  => []
            ];

            $schedule = Schedules::find($id);
            $response['Schedule'][] = [
                    'id' => $schedule->id,
                    'week' => $schedule->week,
                    'set' => $schedule->set,
                    'duration_goal' => $schedule->duration_goal,
                    'distance_goal' => $schedule->distance_goal,
                    'distance_warmup' => $schedule->distance_warmup,
                    'frequency_goal' => $schedule->frequency_goal,
            ];

        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }
    }
}
