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
            'category_id' => 2,
            'cbm' => 12.5,
            'weight' => 125,
            'package' => 8
        ]);  
        
        $item1 = Item::create([
            'name' => '20 GM lawn machine',
            'category_id' => 2,
            'cbm' => 18.2,
            'weight' => 41,
            'package' => 12
        ]);  
        
        $item1 = Item::create([
            'name' => '18 KW boaring machine',
            'category_id' => 2,
            'cbm' => 20,
            'weight' => 65,
            'package' => 4,
            'description' => 'Used for water boaring'
        ]);  

        $item1 = Item::create([
            'name' => 'Guardian 26kW Home Backup Generator WiFi-Enabled',
            'category_id' => 2,
            'cbm' => 25,
            'weight' => 33,
            'package' => 8,
            'description' => 'Generac’s 26kW home standby generator can start all of your home’s large appliances, ensuring your home remains a sanctuary for you and your family.'
        ]);  
        
        $item1 = Item::create([
            'name' => 'Gasoline Garden Tiler',
            'category_id' => 2,
            'cbm' => 21.2,
            'weight' => 42,
            'package' => 8
        ]);  

        
        $item1 = Item::create([
            'name' => 'Diesel Garden Tiler',
            'category_id' => 2,
            'cbm' => 25.5,
            'weight' => 48,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Lawn Mower',
            'category_id' => 2,
            'cbm' => 40.5,
            'weight' => 85,
            'package' => 2
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Brush Cutter',
            'category_id' => 2,
            'cbm' => 18.2,
            'weight' => 41,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Hedge Trimmer',
            'category_id' => 2,
            'cbm' => 26.5,
            'weight' => 4145,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Earth Auger',
            'category_id' => 2,
            'cbm' => 45.5,
            'weight' => 95,
            'package' => 122
        ]);  

        
        $item1 = Item::create([
            'name' => 'Gasoline Knapsak Sprayer',
            'category_id' => 2,
            'cbm' => 55.5,
            'weight' => 105,
            'package' => 2
        ]);  

        
        $item1 = Item::create([
            'name' => 'Mist Duster, Blower, Sprayer',
            'category_id' => 2,
            'cbm' => 22.5,
            'weight' => 75,
            'package' => 6
        ]);  

        
        $item1 = Item::create([
            'name' => '150 AMP only pump',
            'category_id' => 2,
            'cbm' => 45.5,
            'weight' => 82,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => '767 knapsack sprayer',
            'category_id' => 2,
            'cbm' => 22.2,
            'weight' => 31,
            'package' => 10
        ]);  

        
        $item1 = Item::create([
            'name' => '300 bar Electric High Pressure Washers',
            'category_id' => 2,
            'cbm' => 25,
            'weight' => 35,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => '630 AMP Welding Machine',
            'category_id' => 2,
            'cbm' => 15,
            'weight' => 25,
            'package' => 12
        ]);  

        
        $item1 = Item::create([
            'name' => '250 AMP Battery Chargers',
            'category_id' => 2,
            'cbm' => 50,
            'weight' => 110,
            'package' => 1
        ]);  

        
        $item1 = Item::create([
            'name' => '200 ltr Air Compressor',
            'category_id' => 2,
            'cbm' => 29.5,
            'weight' => 49,
            'package' => 4
        ]);  

        
        $item1 = Item::create([
            'name' => '15 hp Deep Well Submersible Pumps',
            'category_id' => 2,
            'cbm' => 23.5,
            'weight' => 35,
            'package' => 6
        ]);  

        
        $item1 = Item::create([
            'name' => '6 inch PVC Hoses',
            'category_id' => 2,
            'cbm' => 12,
            'weight' => 12,
            'package' => 12
        ]);  

        
                
        
    }
}
