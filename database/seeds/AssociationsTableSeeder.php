<?php

use Illuminate\Database\Seeder;
use App\Association;

class AssociationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Association::class, 10)->create();
    }
}
