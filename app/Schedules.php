<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
  public $timestamps = false;
  protected $fillable = [
      'week','set', 'avg_duration','distance_goal', 'distance_warmup', 'frequency_goal'
  ];
}
