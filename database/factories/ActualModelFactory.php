<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ActualModel;
use App\Client;
use Faker\Generator as Faker;

$factory->define(ActualModel::class, function (Faker $faker) {
    return [
        'client_id' =>  $faker->numberBetween($min = 1, $max = 3),
        'actual_model' => $faker->word(10),
        'date' => $faker->date(),
        'amount' => $faker->randomNumber(7),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
