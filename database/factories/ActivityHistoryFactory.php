<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ActivityHistory;
use App\Client;
use App\Pic;
use Faker\Generator as Faker;

$factory->define(ActivityHistory::class, function (Faker $faker) {
    return [
        'client_id' =>  $faker->numberBetween($min = 1, $max = 3),
        'date' => now(),
        'pic_id' =>  $faker->numberBetween($min = 1, $max = 10),
        'reason' => $faker->numberBetween($min = 1, $max = 5),
        'sales_staff_id' => $faker->numberBetween($min = 1, $max = 3),
        'detail' => $faker->realText(20),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
