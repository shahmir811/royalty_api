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
        
                
        
    }
}
