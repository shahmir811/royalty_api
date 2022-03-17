<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\{Credit, Customer, Sale};
use Illuminate\Database\Seeder;

class CreditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credit1 = new Credit;
        $credit1->total_amount_paid = 2500;
        $credit1->due_amount = 1500;
        $credit1->due_date = Carbon::now()->addMonths(3);

        $credit1->customer_id = 1;
        $credit1->sale_id = 1;
        $credit1->save();


        $credit2 = new Credit;
        $credit2->total_amount_paid = 1854;
        $credit2->due_amount = 1500;
        $credit2->due_date = Carbon::now()->addMonths(2);

        $credit2->customer_id = 2;
        $credit2->sale_id = 2;
        $credit2->save();
        
        
        $credit3 = new Credit;
        $credit3->total_amount_paid = 1180;
        $credit3->due_amount = 1180;
        $credit3->due_date = Carbon::now()->addDays(3);

        $credit3->customer_id = 3;
        $credit3->sale_id = 3;
        $credit3->save();        


    }
}
