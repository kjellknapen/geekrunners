<?php

use Faker\Generator as Faker;
$autoIncrement = autoIncrement();

$factory->define(App\Schedules::class, function (Faker $faker) use ($autoIncrement) {
  $autoIncrement->next();
    return [
      'week'=>$autoIncrement->current(),
      'set'=>$faker->numberBetween(1,3),
      'duration_goal'=>$faker->numberBetween(25,120),
      'distance_goal'=>$faker->numberBetween(5,16),
      'distance_warmup'=>$faker->numberBetween(2,8),
      'frequency_goal'=>$faker->numberBetween(1,3),
    ];
});

function autoIncrement()
{
    for ($i = 0; $i <= 25; $i++) {
        yield $i;
    }
}
