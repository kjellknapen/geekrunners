<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    $mail = $faker->unique()->safeEmail;
    return [
        'firstname' => $faker->firstName,
        'lastname'=> $faker->lastName,
        'role' => 'Student',
        'avatar' => "https://api.adorable.io/avatars/285/" . $mail,
        'noavatar' => true,
        'email' => $mail,
        'strava_id'=> str_random(10),
        'token' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
