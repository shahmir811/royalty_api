<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = Item::create([
            'name' => '25 KW generator',
            'cbm' => 12.5,
            'weight' => 125,
            'package' => 8
        ]);  
        
        $item1 = Item::create([
            'name' => '20 GM lawn machine',
            'cbm' => 18.2,
            'weight' => 41,
            'package' => 12
        ]);  
        
        $item1 = Item::create([
            'name' => '18 KW boaring machine',
            'cbm' => 20,
            'weight' => 65,
            'package' => 4,
            'description' => 'Used for water boaring'
        ]);  

        $item1 = Item::create([
            'name' => 'Guardian 26kW Home Backup Generator WiFi-Enabled',
            'cbm' => 25,
            'weight' => 33,
            'package' => 8,
            'description' => 'Generac’s 26kW home standby generator can start all of your home’s large appliances, ensuring your home remains a sanctuary for you and your family.'
        ]);  
        
        $item1 = Item::create([
            'name' => 'Gasoline Garden Tiler',
            'cbm' => 21.2,
            'weight' => 42,
            'package' => 8
        ]);  

        
        $item1 = Item::create([
            'name' => 'Diesel Garden Tiler',
            'cbm' => 25.5,
            'weight' => 48,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Lawn Mower',
            'cbm' => 40.5,
            'weight' => 85,
            'package' => 2
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Brush Cutter',
            'cbm' => 18.2,
            'weight' => 41,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Hedge Trimmer',
            'cbm' => 26.5,
            'weight' => 4145,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Earth Auger',
            'cbm' => 45.5,
            'weight' => 95,
            'package' => 122
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Knapsak Sprayer',
            'cbm' => 55.5,
            'weight' => 105,
            'package' => 2
        ]);  

        
        $item1 = Item::create([
            'name' => 'Mist Duster, Blower, Sprayer',
            'cbm' => 22.5,
            'weight' => 75,
            'package' => 6
        ]);  

        
        $item1 = Item::create([
            'name' => '150 AMP only pump',
            'cbm' => 45.5,
            'weight' => 82,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => '767 knapsack sprayer',
            'cbm' => 22.2,
            'weight' => 31,
            'package' => 10
        ]);  

        
        $item1 = Item::create([
            'name' => '300 bar Electric High Pressure Washers',
            'cbm' => 25,
            'weight' => 35,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => '630 AMP Welding Machine',
            'cbm' => 15,
            'weight' => 25,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => '250 AMP Battery Chargers',
            'cbm' => 50,
            'weight' => 110,
            'package' => 1
        ]);  

        
        $item1 = Item::create([
            'name' => '200 ltr Air Compressor',
            'cbm' => 29.5,
            'weight' => 49,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => '15 hp Deep Well Submersible Pumps',
            'cbm' => 23.5,
            'weight' => 35,
            'package' => 6
        ]);  

        
        $item1 = Item::create([
            'name' => '6 inch PVC Hoses',
            'cbm' => 12,
            'weight' => 12,
            'package' => 12
        ]);  

        
                
        
    }
}
