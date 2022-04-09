<?php

namespace Database\Seeders;

use App\Helper\Seed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Seed::start();
        // \App\Models\User::factory(10)->create();

        $this->call(RoleSeeder::class);

        $this->call(UserTableSeeder::class);

        // $this->call(LocationTableSeeder::class);

        // $this->call(CustomerTableSeeder::class);

        $this->call(StatusTableSeeder::class);

        $this->call(PredefinedValueTableSeeder::class);

        // $this->call(CategoryTableSeeder::class);

        // $this->call(ItemsTableSeeder::class);
        
        // $this->call(InventoryTableSeeder::class);

        // $this->call(PurchaseSeeder::class);

        // $this->call(SaleSeeder::class);  
        
        // $this->call(CreditTableSeeder::class);   
         
    }
}
