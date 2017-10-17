<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $fillable = [
        'name', 'user_id', 'strava_id', 'date', 'map_id', 'average_speed', 'max_speed', 'km', 'minutes'
    ];
}
