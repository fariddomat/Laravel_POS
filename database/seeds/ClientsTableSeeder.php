<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
          
        $clients=['Farid','Geo','Mary'];
        foreach ($clients as $client) {
            \App\Client::create([
                'name'=>$client,
                'phone'=>'0123456789',
                'address'=>'Homs',
        ]);
        }
    }
}
