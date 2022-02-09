<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AssociationClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
    	DB::table('association_client')->insert([
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
	    	    'association_id' => $faker->numberBetween($min = 1, $max = 10),
                'client_id' => $faker->numberBetween($min = 1, $max = 3),
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
        ]);
    }
}
