<?php

use Illuminate\Database\Seeder;
use App\Pic;

class PicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Pic::class, 10)->create();
    }
}
