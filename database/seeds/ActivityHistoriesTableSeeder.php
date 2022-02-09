<?php

use Illuminate\Database\Seeder;
use App\ActivityHistory;

class ActivityHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ActivityHistory::class, 20)->create();
    }
}
