<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pic;
use App\Client;
use Faker\Generator as Faker;

$factory->define(Pic::class, function (Faker $faker) {
    return [
        'client_id' => $faker->numberBetween($min = 1, $max = 3),
        'name' => $faker->name,
        'supplement' => $faker->numberBetween($min = 1, $max = 2),
        'position' => $faker->numberBetween($min = 1, $max = 7),
        'cellphone_number' => $faker->phoneNumber(),
        'email' => $faker->safeEmail(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
