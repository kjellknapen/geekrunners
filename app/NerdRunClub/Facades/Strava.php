<?php

namespace NerdRunClub\Facades;
use Illuminate\Support\Facades\Facade;

class Strava extends Facade{
    protected static function getFacadeAccessor() {
        return 'Strava';

    }
}