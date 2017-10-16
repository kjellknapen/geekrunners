<?php

namespace App\Http\Controllers;

use App\Activities;
use App\StravaHandler;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(){
        $this->retrieveActivities();
        $result = Activities::all()->where('user_id', Auth::id());
        return view('dashboard/index', ['runs' => $result]);
    }

    public function retrieveActivities(){
        $url = 'https://www.strava.com/api/v3/activities/';
        $token = Auth::user()->token;

        $result = StravaHandler::get($url, $token);

        foreach ($result as $run) {
            $date = strtotime($run->start_date);
            $check_activities = Activities::all()->where('strava_id', $run->id)->first();
            if($check_activities){
                // Don't Save
            }else {
                Activities::create([
                    'name' => $run->name,
                    'user_id' => Auth::id(),
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
