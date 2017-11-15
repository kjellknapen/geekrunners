<?php

use Faker\Generator as Faker;

$factory->define(App\Achievement::class, function (Faker $faker) {

    return [
        'img' => $faker->unique()->randomElement([
            '/img/badges-01.svg',
            '/img/badges-02.svg',
            '/img/badges-03.svg',
            '/img/badges-04.svg',
            '/img/badges-05.svg',
            '/img/badges-06.svg',
            '/img/badges-07.svg',
            '/img/badges-08.svg',
            '/img/badges-09.svg',
            '/img/badges-10.svg',
            '/img/badges-11.svg',
            '/img/badges-12.svg',
        ]),
        'description' => $faker->unique()->randomElement([
        'badge-01',
        'badge-02',
        'badge-03',
        'badge-04',
        'badge-05',
        'badge-06',
        'badge-07',
        'badge-08',
        'badge-09',
        'badge-10',
        'badge-11',
        'badge-12',
    ])
    ];
});

