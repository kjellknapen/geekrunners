<?php

namespace App\Http\Controllers;

use App\Activity;
use App\NerdRunClub\Strava;
use App\User;
use App;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
use NerdRunClub\Calculations;

class DashboardController extends Controller
{
    //

    public function index(){

//        $users = User::find(1);
//        dd($users->firstname);

        $topRunners = Calculations::getTopRunners();
        $topRunnersResult = [];
        foreach ($topRunners as $key=>$value){
            array_push($topRunnersResult, [
                'user' => User::find($key),
                'km' => $value,
            ]);
        }

        //dd($topRunnersResult);

        return view('dashboard/index', ['userStats' => Calculations::getUserStats(), 'topRunners' => $topRunnersResult]);
    }
}
