<?php

use Illuminate\Database\Seeder;
use App\ActualModel;

class ActualModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ActualModel::class, 10)->create();
    }
}
