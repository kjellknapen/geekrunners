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
    private $client;
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->client_id = $_ENV['STRAVA_KEY'];
        $this->client_secret = $_ENV['STRAVA_SECRET'];
        $this->redirect_uri = $_ENV['STRAVA_REDIRECT_URI'];
    }

    public function redirect(){
        return redirect('https://www.strava.com/oauth/authorize?client_id=20590&response_type=code&redirect_uri='. $this->redirect_uri .'&state=mystate&approval_prompt=force');
    }

    public function tokenExchange($code){
        //$url = "'https://www.strava.com/oauth/token?client_id=20594&client_secret=426f99ae57f2c243fdcc6e5fa320c011523c6161&code=".$code."'";
        $res = $this->client->request('POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '20590',
                'client_secret' => 'f547d41bb416342504f68b64aa24216544d3154d',
                'code' => $code,
            ]
        ]);

        $result= \GuzzleHttp\json_decode($res->getBody());
        return $result;
    }

    public function post(){

    }

    public function get( $url, $config ){

        $res = $this->client->get( $url, $config );

        $result = \GuzzleHttp\json_decode($res->getBody()->getContents());

        return $result;
    }
}