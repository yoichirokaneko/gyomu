<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	UsersTableSeeder::class,
            // AssociationsTableSeeder::class,
            SalesStaffTableSeeder::class,
        	// ClientsTableSeeder::class,
            // PicsTableSeeder::class,
            // ActualModelsTableSeeder::class,
            // ActivityHistoriesTableSeeder::class,
            // PropertiesTableSeeder::class,
            // AssociationClientTableSeeder::class,
        ]);
    }
}
