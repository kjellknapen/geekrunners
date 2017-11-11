<?php

use Faker\Generator as Faker;

$factory->define(App\AdminPassword::class, function (Faker $faker) {

    $hashedpass = \Illuminate\Support\Facades\Hash::make('WeAreIMD', [
        'rounds' => 12
    ]);
    return [
        'password' => $hashedpass
    ];
});
