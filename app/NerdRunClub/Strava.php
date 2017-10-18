<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 11.10.17
 * Time: 11:26
 */

namespace App\NerdRunClub;


use GuzzleHttp\Client;
use Psy\Util\Str;

class Strava
{
    private static $client;
    private static $client_id;
    private static $client_secret;
    private static $redirect_uri;
    
    public function __construct()
    {
        self::$client = new Client();
        self::$client_id = $_ENV['STRAVA_KEY'];
        self::$client_secret = $_ENV['STRAVA_SECRET'];
        self::$redirect_uri = $_ENV['STRAVA_REDIRECT_URI'];
    }

    public static function redirect(){
        return redirect('https://www.strava.com/oauth/authorize?client_id=20590&response_type=code&redirect_uri='. self::$redirect_uri .'&state=mystate&approval_prompt=force');
    }

    public static function tokenExchange($code){
        //$url = "'https://www.strava.com/oauth/token?client_id=20594&client_secret=426f99ae57f2c243fdcc6e5fa320c011523c6161&code=".$code."'";
        $res = self::$client->request('POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => self::$client_id,
                'client_secret' => self::$client_secret,
                'code' => $code,
            ]
        ]);

        $result= \GuzzleHttp\json_decode($res->getBody());
        return $result;
    }

    public static function post(){

    }

    public static function get( $url, $config ){

        $res = self::$client->get( $url, $config );

        $result = \GuzzleHttp\json_decode($res->getBody()->getContents());

        return $result;
    }
}