<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use Illuminate\Support\Facades\DB;
use NerdRunClub\Calculations;


class UserController extends Controller
{
    //
    public function index(){

        $result = Activity::take(5)->where('user_id', Auth::id())->get();
        $userStats = [
            'total' => 0,
            'distance' => 0,
            'time' => 0
        ];
        
        $from = new Carbon('sunday last week');
        $to = new Carbon('sunday this week');

        $thisWeeksActivities = Activity::all()->where('user_id', Auth::id())->where('date', '>' , $from)->where('date', '<' , $to);
        foreach ($thisWeeksActivities as $activity){
            $userStats['total'] += 1;
            $userStats['distance'] += $activity->km;
            $userStats['time'] += $activity->minutes;
        }
        $achievementsDone = DB::table('achievements')->get();
        
        return view("user.index", ['runs' => $result, 'userStats' => $userStats, 'achievements' => $achievementsDone]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
