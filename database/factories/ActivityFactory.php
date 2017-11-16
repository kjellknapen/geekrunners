<?php

use Faker\Generator as Faker;

$factory->define(App\Activity::class, function (Faker $faker) {

    $user_id = \App\User::all()->pluck('id');

    return [
      'user_id'=> $user_id[rand(1, count($user_id)-1)],
      'name'=> $faker->name,
      'strava_id'=> str_random(10),
      'date'=> new DateTime(),
      'map_id'=> str_random(10),
      'average_speed'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
      'max_speed'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 15),
      'km'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 15),
//      'minutes'=>$faker->randomNumber($nbDigits = 2, $strict = false),
      'minutes'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 15, $max = 45),
    ];
});
