<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventoryTableSeeder extends Seeder
{

    public function run()
    {
        $invt1 = Inventory::create([
            'item_id' => 1,
            'quantity' => 20,
            'purchase_price' => 105.5,
            'avg_price' => 105.5,
            'sale_price' => 107.5,
            'location_id' => 1,
        ]);        

        $invt2 = Inventory::create([
            'item_id' => 2,
            'quantity' => 10,
            'purchase_price' => 100,
            'avg_price' => 100,
            'sale_price' => 103,
            'location_id' => 1,
        ]);        


        $invt1 = Inventory::create([
            'item_id' => 1,
            'quantity' => 9,
            'purchase_price' => 105.5,
            'avg_price' => 105.5,
            'sale_price' => 107.5,
            'location_id' => 2,
        ]);        


        $invt2 = Inventory::create([
            'item_id' => 2,
            'quantity' => 10,
            'purchase_price' => 100,
            'avg_price' => 100,
            'sale_price' => 103,
            'location_id' => 2,
        ]);
        
        $invt1 = Inventory::create([
            'item_id' => 3,
            'quantity' => 10,
            'purchase_price' => 85,
            'avg_price' => 86,
            'sale_price' => 87,
            'location_id' => 1,
        ]);        

        $invt2 = Inventory::create([
            'item_id' => 4,
            'quantity' => 23,
            'purchase_price' => 50,
            'avg_price' => 53,
            'sale_price' => 55,
            'location_id' => 2,
        ]);    


        $invt1 = Inventory::create([
            'item_id' => 5,
            'quantity' => 33,
            'purchase_price' => 25,
            'avg_price' => 29,
            'sale_price' => 35,
            'location_id' => 3,
        ]);        

        $invt2 = Inventory::create([
            'item_id' => 6,
            'quantity' => 25,
            'purchase_price' => 61,
            'avg_price' => 63,
            'sale_price' => 65,
            'location_id' => 3,
        ]);    


        $invt1 = Inventory::create([
            'item_id' => 7,
            'quantity' => 27,
            'purchase_price' => 70,
            'avg_price' => 71,
            'sale_price' => 72,
            'location_id' => 2,
        ]);        

        $invt2 = Inventory::create([
            'item_id' => 8,
            'quantity' => 17,
            'purchase_price' => 63,
            'avg_price' => 65,
            'sale_price' => 67,
            'location_id' => 3,
        ]);    

    }
}
