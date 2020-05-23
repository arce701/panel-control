<?php
/** @var Factory $factory */

use App\User;
use App\UserProfile;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$ZwGRn793jmScCZ8c9s3mR.6YIfCcVGghmAf3PGgf5xiZR5lvTYIey',
        'remember_token' => Str::random(10),
        'role' => 'user',
        'active' => true,
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user->profile()->save(factory(UserProfile::class)->make());
});

$factory->state(User::class, 'inactive', function ($fake) {
    return [
        'active' => false
    ];
});
