<?php

use Illuminate\Database\Seeder;
use App\Client;
use App\ActivityHistory;
use App\ActualModel;
use App\Property;
use App\Pic;


class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class, 3)->create();
       
        // $clients = factory(Client::class, 3)->make();
        // Client::query()->insert($clients->toArray());
        
        // $clients = Client::query()->orderBy('created', 'desc')->limit(3)->get();
        // $clients->each(function (Client $client) {
        //     $activityHistories = factory(ActivityHistory::class, 10)->make(['client_id' => $client->id]);
        //     ActivityHistory::query()->insert($activityHistories->toArray());
            
        //     $activityHistories = ActivityHistory::query()->orderBy('created', 'desc')->limit(10)->get();
        //     $activityHistories->each(function(ActivityHistory $activityHistory) {
        //         $properties = factory(Property::class, 1)->make(['client_id' => $client->id, 'activity_history_id' => $activityHistory->id]);
        //         Property::query()->insert($properties->toArray());
        //     });


        //     $pics = factory(Pic::class, 3)->make(['client_id' => $client->id]);
        //     Pic::query()->insert($pics->toArray());
            
        //     $actualModels = factory(ActualModel::class, 3)->make(['client_id' => $client->id]);
        //     ActualModel::query()->insert($actualModels->toArray());
            

            // $client->properties()->saveMany(factory(Property::class, 5)->make());
            // $client->pics()->saveMany(factory(Pic::class, 3)->make());
            // $client->pics()->saveMany(factory(ActualModel::class, 3)->make());
            // factory(Property::class, 5)->create(['client_id' => $client->id]);
            // factory(ActualModel::class, 3)->create(['client_id' => $client->id]);
            // factory(Pic::class, 3)->create(['client_id' => $client->id]);
    //     });
    }
}
