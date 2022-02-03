<?php

namespace Database\Seeders;

use App\Models\{Payment};
use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * Run following command 04 times
     * php artisan db:seed --class=PaymentTableSeeder
     */
    public function run()
    {
        $payment1               = new Payment;
        $payment1->amount       = 250;
        $payment1->user_id      = 3;
        $payment1->credit_id    = 1;
        $payment1->save();

        // $payment2               = new Payment;
        // $payment2->amount       = 300;
        // $payment2->user_id      = 3;
        // $payment2->credit_id    = 1;
        // $payment2->save();

        // $payment3               = new Payment;
        // $payment3->amount       = 500;
        // $payment3->user_id      = 3;
        // $payment3->credit_id    = 1;
        // $payment3->save();

    }
}
