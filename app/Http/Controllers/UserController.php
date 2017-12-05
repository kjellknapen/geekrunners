<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Activity;
use Illuminate\Support\Facades\DB;
use NerdRunClub\Calculations;


class UserController extends Controller
{
    //
    public function index(){

        // Get the users activities
        $result = Activity::orderBy('updated_at','DESC')->take(5)->where('user_id', Auth::id())->get();
        $userStats = [
            'total' => 0,
            'distance' => 0,
            'time' => 0
        ];
        
        $from = new Carbon('sunday last week');
        $to = new Carbon('sunday this week');

        // Calculate the user stats for his runs
        $thisWeeksActivities = Activity::all()->where('user_id', Auth::id())->where('date', '>' , $from)->where('date', '<' , $to);
        foreach ($thisWeeksActivities as $activity){
            $userStats['total'] += 1;
            $userStats['distance'] += $activity->km;
            $userStats['time'] += $activity->minutes;
        }
        $achievementsDone = DB::table('achievements')->get();
        
        return view("user.index", ['runs' => $result, 'userStats' => $userStats, 'achievements' => $achievementsDone]);
    }

    public function show($id)
    {
        $user = User::find($id);


        $result = Activity::orderBy('updated_at','DESC')->take(5)->where('user_id', $user['id'])->get();

//        dd($result);

        $userStats = [
            'total' => 0,
            'distance' => 0,
            'time' => 0
        ];

        $from = new Carbon('sunday last week');
        $to = new Carbon('sunday this week');

        $thisWeeksActivities = Activity::all()->where('user_id', $user['id'])->where('date', '>' , $from)->where('date', '<' , $to);
        foreach ($thisWeeksActivities as $activity){
            $userStats['total'] += 1;
            $userStats['distance'] += $activity->km;
            $userStats['time'] += $activity->minutes;
        }
        $achievementsDone = DB::table('achievements')->get();

        return view("user.user", ['otheruser'=> $user, 'runs' => $result, 'userStats' => $userStats, 'achievements' => $achievementsDone]);


    }

    public function logout(){
        // Logout the user
        Auth::logout();
        return redirect('/');
    }

    public function enableMail(){
        // Enable mail notifications
        User::find(Auth::id())->update([
            'notifications' => true
        ]);

        return "hello";
    }

    public function disableMail(){
        // Disable mail notification
        User::find(Auth::id())->update([
            'notifications' => false
        ]);

        return "hello";
    }
}
