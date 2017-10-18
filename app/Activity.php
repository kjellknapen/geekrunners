<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name', 'user_id', 'strava_id', 'date', 'map_id', 'average_speed', 'max_speed', 'km', 'minutes'
    ];
}
