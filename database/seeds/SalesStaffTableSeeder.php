<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SalesStaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
    	DB::table('sales_staff')->insert([
            [
	    	    'name' => '田中',
	    	    'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
                'name' => '山磨',
                'created_at' => now(),
			    'updated_at' => now(),
            ],
            [
                'name' => '他',
                'created_at' => now(),
			    'updated_at' => now(),
            ],
        ]);
    }
}
