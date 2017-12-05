<?php

namespace App\Http\Controllers;

use App\User;
use NerdRunClub\Calculation;

class LeaderboardController extends Controller
{
    //
    public function index(Calculation $calculation){
        // Get the leaderboard stats
        $leaderboards = $calculation->getLeaderboardStats();
        return view('leaderboards/index', ['leaderboard' => $leaderboards]);
    }

    public function hallOfFame(Calculation $calculation){
        $topfive = [
          "first" => [
              "completed" => 0,
              "user" => ""
          ],
          "second" => [
              "completed" => 0,
              "user" => ""
          ],
          "third" => [
              "completed" => 0,
              "user" => ""
          ],
          "fourth" => [
              "completed" => 0,
              "user" => ""
          ],
          "fifth" => [
              "completed" => 0,
              "user" => ""
          ]
        ];

        $completedgoals = 0;
        $allusers = User::all();
        $currentWeek = $calculation->currentWeek();
        foreach($allusers as $u){
            $goals = $calculation->weeklyGoalsTree($u, $currentWeek);
            foreach($goals as $goal){
                if($goal === "completed"){
                    $completedgoals += 1;
                }
            }
            if($topfive["first"]["completed"] < $completedgoals || $topfive["first"]["completed"] == 0 && $topfive["first"]["user"] == ""){
                $topfive["first"]["completed"] = $completedgoals;
                $topfive["first"]["user"] = $u;
            }elseif($topfive["second"]["completed"] < $completedgoals || $topfive["second"]["completed"] == 0 && $topfive["second"]["user"] == ""){
                $topfive["second"]["completed"] = $completedgoals;
                $topfive["second"]["user"] = $u;
            }elseif($topfive["third"]["completed"] < $completedgoals || $topfive["third"]["completed"] == 0 && $topfive["third"]["user"] == ""){
                $topfive["third"]["completed"] = $completedgoals;
                $topfive["third"]["user"] = $u;
            }elseif($topfive["fourth"]["completed"] < $completedgoals || $topfive["fourth"]["completed"] == 0 && $topfive["fourth"]["user"] == ""){
                $topfive["fourth"]["completed"] = $completedgoals;
                $topfive["fourth"]["user"] = $u;
            }elseif($topfive["fifth"]["completed"] < $completedgoals || $topfive["fifth"]["completed"] == 0 && $topfive["fifth"]["user"] == ""){
                $topfive["fifth"]["completed"] = $completedgoals;
                $topfive["fifth"]["user"] = $u;
            }else{

            }
            $completedgoals = 0;
        }
        return view("leaderboards/halloffame", ["topfive" => $topfive]);
    }
}
