<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company(),
        'rank' => $faker->numberBetween($min = 1, $max = 5),
        'office_address' => $faker->address(),
        'office_address_code' => $faker->postcode(),
        'office_tel' => $faker->phoneNumber(),
        'office_fax' => $faker->phoneNumber(),
        'place_address' => $faker->address(),
        'place_address_code' => $faker->postcode(),
        'place_tel' => $faker->phoneNumber(),
        'place_fax' => $faker->phoneNumber(),
        'sales_channel' => $faker->numberBetween($min = 1, $max = 4),
        'sales_channel_company_name' => $faker->company(),
        'note' => $faker->realText(30),
        'created_at' => now(), 
        'updated_at' => now(),  
    ];
});
