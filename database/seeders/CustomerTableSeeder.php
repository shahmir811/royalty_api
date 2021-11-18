<?php

namespace Database\Seeders;

use App\Models\{Customer};
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $customer1 = Customer::create([
            'name' => 'David Warner',
            'country' => 'Australia',
            'mark' => 'Mark of wound on chin', 
            'mobile_no_dubai' => '+971 100 544335',
            'mobile_no_country' => '+61 485 273062',
            'cargo_address' => $faker->address(),
            'credit_amount' => 0,
        ]);

        $customer1 = Customer::create([
            'name' => 'Micheal Owen',
            'country' => 'United Kingdom',
            'mark' => 'Cut on right arm elbow',
            'mobile_no_dubai' => '+971 513 125365',
            'mobile_no_country' => '+44 7860 980 202',
            'cargo_address' => $faker->address(),
            'credit_amount' => 0,
        ]);        

        $customer1 = Customer::create([
            'name' => 'Muhammad Ahmed',
            'country' => 'Saudi Arabia',
            'mark' => 'Mark on right knee',
            'mobile_no_dubai' => '+971 555 654123',
            'mobile_no_country' => '+966 123 789456',
            'cargo_address' => $faker->address(),
            'credit_amount' => 0,
        ]);                

    }
}
