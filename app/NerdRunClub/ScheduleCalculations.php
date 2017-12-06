<?php

namespace NerdRunClub;

use App\schedules;
use App\Event;

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

    public function create_schedule(){
      $weeks =  $this->calculate_weeks();
      $sets = $this->calculate_sets();
      $event = event::find(1);
      $distance = $event->distance;
      //1) Create a DB entry per week
      for ($i=0; $i < $weeks; $i++) {
        $schedule = new schedules;
        //Determine week
        $week = $i+1;
        $schedule->week = $week;
        //determine set;
        $set = ceil($week/3);
        $schedule->set = $set;

        //speed goes up per third of training completed
        if ($set <= $sets/3) {
          $speed = 7;
        }
        elseif ($set>$sets/3 && $set <= $sets*(2/3)) {
          $speed = 8;
        }
        else {
          $speed = 9
          ;
        }
        $schedule->frequency_goal = 2;
        $schedule->distance_goal =  round($distance/$sets * $set);
        $distance =
        //Position inside set determines all other params
        switch ($week%3) {

          case 2:
            //distance ramps up during intense training week
            $schedule->distance_goal =  round($distance/$sets * $set)+1;
            break;

          case 0:
            //Only two sessions in the recuperation weeks
            $schedule->frequency_goal = 1;
            break;
        }

        //last week doesn't get training increase -> already at max distance + only one session to warm up for the big day.
        if ($week == $weeks) {
          $schedule->distance_goal =  round($distance/$sets * $set);
          $schedule->frequency_goal = 1;
        }

          $frequency = $schedule->frequency_goal;
          $distance_goal = $schedule->distance_goal;
          $schedule->duration_goal = 60/($speed/$distance_goal) * $frequency;
          $duration =   $schedule->duration_goal;
          //Rework into hours - minutes because noone uses 350 minutes.
          //$hours = intval($duration/60);
          //$minutes = $duration - ($hours * 60);

        $schedule->save();
      }
    }
}
