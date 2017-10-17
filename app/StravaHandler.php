<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 11.10.17
 * Time: 11:26
 */

namespace App;


use GuzzleHttp\Client;
use Psy\Util\Str;

class StravaHandler
{
    public static function redirect(){
        return redirect('https://www.strava.com/oauth/authorize?client_id=20590&response_type=code&redirect_uri=http://nerdrunclub.app/token_exchange&state=mystate&approval_prompt=force');
    }

    public static function tokenExchange($code){
        $client = new Client();
        //$url = "'https://www.strava.com/oauth/token?client_id=20594&client_secret=426f99ae57f2c243fdcc6e5fa320c011523c6161&code=".$code."'";
        $res = $client->request('POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '20590',
                'client_secret' => 'f547d41bb416342504f68b64aa24216544d3154d',
                'code' => $code,
            ]
        ]);

        $result= \GuzzleHttp\json_decode($res->getBody());
        return $result;
    }

    public static function post(){

    }

    public static function get( $url, $token ){

        $client = new Client();
        $res = $client->get( $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ]
        ] );

        $result = \GuzzleHttp\json_decode($res->getBody()->getContents());

        return $result;
    }

    public static function retrieveActivities(){
        $url = 'https://www.strava.com/api/v3/activities/';
        $users = User::all();

        foreach ($users as $u) {
            $token = $u->token;

            $result = StravaHandler::get($url, $token);

            foreach ($result as $run) {
                $date = strtotime($run->start_date);
                $check_activities = Activities::all()->where('strava_id', $run->id)->first();
                if ($check_activities) {
                    // Don't Save
                } else {
                    Activities::create([
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