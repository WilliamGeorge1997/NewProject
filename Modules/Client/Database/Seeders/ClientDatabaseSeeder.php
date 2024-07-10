<?php

namespace Modules\Client\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;

class ClientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $datetime = new Carbon('2022-07-15');
        for ($i=1; $i <= 30 ; $i++) { 
            Client::create([
            'name' => 'Client',
            'phone' => '050000000'.$i,
             'password' => bcrypt('123456789'),
             'created_at' => $datetime,
         ]);
         $datetime->addDay();
        }
        
        // $this->call("OthersTableSeeder");
    }
}
