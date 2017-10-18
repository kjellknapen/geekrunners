<?php

use Faker\Generator as Faker;

$factory->define(App\Activities::class, function (Faker $faker) {
    return [
      'user_id'=>$faker->numberBetween($min = 1, $max = 50),
      'name'=> $faker->name,
      'strava_id'=> str_random(10),
      'date'=> date("d/m/Y H:i:s"),
      'map_id'=> str_random(10),
      'average_speed'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
      'max_speed'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 15),
      'km'=>$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
      'minutes'=>$faker->randomNumber($nbDigits = 2, $strict = false),
    ];
});
