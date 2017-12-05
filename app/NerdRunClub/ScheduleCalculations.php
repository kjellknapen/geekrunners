<?php

namespace NerdRunClub;

use App\schedules;

class ScheduleCalculations
{

  public function __construct(){
     $this->calculations = app()->make("Calculation");
  }

    public function calculate_weeks(){
    $startdate = $this->calculations->getStartDate();
    $enddate = $this->calculations->getEndDate();
    $weeks = $enddate->diffInWeeks($startdate);
    return $weeks;
    }

    public function calculate_sets(){
    $weeks =  $this->calculate_weeks();
    $sets = ceil($weeks/3);
    return $sets;
    }

    public function calculate_speed(){
      $speed = 7;
      return $speed;
    }

    public function create_schedule(){
      $weeks =  $this->calculate_weeks();
      $sets = $this->calculate_sets();
      //1) Create a DB entry per week
      for ($i=0; $i < $weeks; $i++) {
        $schedule = new schedules;
        //Determine week
        $week = $i+1;
        $schedule->week = $week;
        //determine set;
        $set = ceil($i/3);
        $schedule->set = $set;
        //Position inside set determines all other params
        switch ($week%3) {
          case 1:
            //Frequency differs only for last case
            $frequency = 3;
            $schedule->frequency_goal = $frequency


            break;

          case 2:
            $schedule->frequency_goal = 3;
            break;

          case 0:
            $schedule->frequency_goal = 2;
            break;

          default:
            $schedule->frequency_goal = 0;
            $schedule->distance_goal = 10;
            $schedule->duration_goal = 0;
            break;
        }
        $schedule->duration_goal = 0;
        $schedule->distance_goal =  $weeks/$sets * 1;
        $schedule->save();
      }
    }
}
