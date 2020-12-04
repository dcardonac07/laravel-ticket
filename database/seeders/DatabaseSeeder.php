<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $amount = 1000; //Number of tickets to create.
        $idEvent = 1; //Test event id.

        //Populate test users.
        \App\Models\User::factory(10)->create();

        //Populate event test.
        DB::table('events')->insert([
            'id' => $idEvent,
            'name' => 'Primer evento',
            'amount' => $amount,
            'remaining' => $amount,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        //Assign the test tickets.
        for ($i=1; $i <= $amount; $i++) {
            DB::table('tickets')->insert([
               'event_id' => $idEvent,
               'number' => $i,
               'created_at'=>date('Y-m-d H:i:s'),
               'updated_at'=>date('Y-m-d H:i:s'),
           ]);
       }
    }
}
