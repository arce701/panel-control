<?php

use App\Login;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Login::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTime,
    ];
});
