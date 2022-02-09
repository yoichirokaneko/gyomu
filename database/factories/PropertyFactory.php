<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Property;
use App\Client;
use App\ActivityHistory;
use App\Pic;
use App\SalesStaff;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'client_id' => $faker->numberBetween($min = 1, $max = 3),
        'activity_history_id' => $faker->numberBetween($min = 1, $max = 20),
        'status' => $faker->numberBetween($min = 1, $max = 4),
        'pic_id' => $faker->numberBetween($min = 1, $max = 10),
        'reason' => $faker->numberBetween($min = 1, $max = 5),
        'sales_staff_id' => $faker->numberBetween($min = 1, $max = 3),
        'model' => $faker->word(10),
        'introduction_date' => now(),
        'note' => $faker->realText(20),
        'answer_date' => now(),
        'created_at' => now(),
        'updated_at' => now(),
        'name' => $faker->word(10),
    ];
});
