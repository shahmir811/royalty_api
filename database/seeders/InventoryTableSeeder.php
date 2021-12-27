<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventoryTableSeeder extends Seeder
{

    public function run()
    {
        $invt1 = Inventory::create([
            // 'item_name' => '25 KW generator',
            'item_id' => 1,
            'quantity' => 20,
            // 'cbm' => 12.5,
            // 'weight' => 25,
            'purchase_price' => 105.5,
            'avg_price' => 105.5,
            'sale_price' => 107.5,
            'location_id' => 1,
            // 'package' => 8
        ]);        

        $invt2 = Inventory::create([
            // 'item_name' => '20 GM lawn machine',
            'item_id' => 2,
            'quantity' => 10,
            // 'cbm' => 15,
            // 'weight' => 20,
            'purchase_price' => 100,
            'avg_price' => 100,
            'sale_price' => 103,
            'location_id' => 1,
            // 'package' => 12
        ]);        


        $invt1 = Inventory::create([
            // 'item_name' => '25 KW generator',
            'item_id' => 1,
            'quantity' => 9,
            // 'cbm' => 12.5,
            // 'weight' => 25,
            'purchase_price' => 105.5,
            'avg_price' => 105.5,
            'sale_price' => 107.5,
            'location_id' => 2,
            // 'package' => 8
        ]);        


        $invt2 = Inventory::create([
            // 'item_name' => '20 GM lawn machine',
            'item_id' => 2,
            'quantity' => 10,
            // 'cbm' => 15,
            // 'weight' => 20,
            'purchase_price' => 100,
            'avg_price' => 100,
            'sale_price' => 103,
            'location_id' => 2,
            // 'package' => 12
        ]);        
    }
}
