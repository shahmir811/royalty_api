<?php

namespace Database\Seeders;

use App\Models\{Location};
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location1 = Location::create([
            'name' => 'Main market, Dubai',
            'contact_no' => '+971 600 544445',
        ]);

        $location1 = Location::create([
            'name' => 'Warehouse store, Abu Dhabi',
            'contact_no' => '+971 500 123456',
        ]);        
    }
}
