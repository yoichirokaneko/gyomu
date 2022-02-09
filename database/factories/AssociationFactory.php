<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Association;
use Faker\Generator as Faker;

$factory->define(Association::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company(),
        'address' => $faker->address(),
        'address_code' => $faker->postcode(),
        'pic_name' => $faker->name(),
        'tel' => $faker->phoneNumber(),
        'email' => $faker->safeEmail(),
        'fax' => $faker->phoneNumber(),
        'note' => $faker->realText(30),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
