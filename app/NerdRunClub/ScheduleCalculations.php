<?php

namespace NerdRunClub;

use App\Schedules;
use App\Event;

class ScheduleCalculations
{

  public function __construct($startdate, $enddate, $distance){
    $this->startdate = $startdate;
    $this->enddate = $enddate;
    $this->distance = $distance;
    $this->allschedules = [];
     $this->calculations = app()->make("Calculation");
  }

    public function calculate_weeks(){
    $startdate = $this->startdate;
    $enddate = $this->enddate;
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
      $event = Event::find(1);
      $distance = $this->distance;
      //1) Create a DB entry per week
      for ($i=0; $i < $weeks; $i++) {
        $schedule = new Schedules;
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
          $speed = 9;
        }
        //standard frequency is 2;
        $schedule->frequency_goal = 2;
        $frequency = $schedule->frequency_goal;

        //goal distance ramps up linearly
        $schedule->distance_goal =  round($distance/$sets * $set);
        $distance_goal = $schedule->distance_goal;

        //warm up ramps up in relation to the goal with a factor of 1/3th
        $schedule->distance_warmup = $distance_goal * (1/3);

        //avg duration is calculated on avg speed and distance -> not too fast, because you might burn yourself out;
        $schedule->avg_duration = 60/($speed/$distance_goal) + 60/($speed/$schedule->distance_warmup);
        if (round($schedule->distance_warmup) == 0) {
          $schedule->distance_warmup = 1;
        }

        //Position inside set determines all other params
        switch ($week%3) {

          case 2:
            //distance ramps up extra during intense training week

            break;

          case 0:
            //Only one session in the recuperation weeks, no warm-up;
            $schedule->frequency_goal = 1;
            $schedule->distance_warmup = 0;
            $schedule->avg_duration = 60/($speed/$distance_goal);
            break;
        }

        //last week doesn't get training increase -> already at max distance + only one session to warm up for the big day.
        if ($week == $weeks) {
          $schedule->frequency_goal = 1;
          $schedule->distance_warmup = 0;
          $schedule->avg_duration = 60/($speed/$distance_goal);
        }

        array_push($this->allschedules, $schedule);
      }
        return (object)$this->allschedules;
    }
}
