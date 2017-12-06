<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 20.10.17
 * Time: 17:22
 */

namespace NerdRunClub;


use App\Activity;
use App\User;
use Carbon\Carbon;
use NerdRunClub\Facades\Strava;

class Request
{
    public static function retrieveActivities($u){
        $url = 'https://www.strava.com/api/v3/activities/';
        if(ctype_digit( $u->strava_id )) {
            $config = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $u->token
                ]
            ];

            $result = Strava::get($url, $config);
            foreach ($result as $run) {
                $http_request = \Illuminate\Support\Facades\Request::getHost();
                if($http_request == "https://geekrunners-beta.weareimd.be" || $http_request == "geekrunners-beta.weareimd.be" || $http_request == "nerdrunclub.app" || $http_request == "localhost"){
                    if ($run->max_speed < 5.5 && $run->average_speed < 5.5) {
                        Activity::firstOrCreate(['strava_id' => $run->id],[
                            'name' => $run->name,
                            'user_id' => $u->id,
                            'map_id' => $run->map->id,
                            'date' => new Carbon($run->start_date),
                            'average_speed' => $run->average_speed*3.6,
                            'max_speed' => $run->max_speed,
                            'km' => number_format($run->distance / 1000, 2),
                            'minutes' => floor($run->elapsed_time / 60),
                        ]);
                    }
                }else{
                    if ($run->max_speed < 5.5 && $run->average_speed < 5.5 && $run->manual == false) {
                        Activity::firstOrCreate(['strava_id' => $run->id],[
                            'name' => $run->name,
                            'user_id' => $u->id,
                            'map_id' => $run->map->id,
                            'date' => new Carbon($run->start_date),
                            'average_speed' => $run->average_speed*3.6,
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