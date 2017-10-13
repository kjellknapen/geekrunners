<?php

namespace App\Http\Controllers;

use App\StravaHandler;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(){
        $url = 'https://www.strava.com/api/v3/activities/';
        $token = Auth::user()->token;

        $result = StravaHandler::get($url, $token);
        return view('dashboard/index', ['runs' => $result]);
    }
}
