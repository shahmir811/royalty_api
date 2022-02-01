<?php

namespace Database\Seeders;

use App\Models\{User, Purchase, PurchaseDetail };
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::findOrFail(3);

        $purchase1 = new Purchase;
        $purchase1->local_purchase = 1;
        $purchase1->total_amount = 1605;
        $purchase1->user_id = $user->id;
        $purchase1->purchase_invoice_no = time() . 'p';
        $purchase1->save();

        $detail1 = new PurchaseDetail;
        $detail1->price = 108;
        $detail1->quantity = 10;
        $detail1->total_price = 1080;
        $detail1->item_id = 1;
        $detail1->location_id = 1;
        $detail1->purchase_id = $purchase1->id;
        $detail1->save();

        $detail1 = new PurchaseDetail;
        $detail1->price = 105;
        $detail1->quantity = 5;
        $detail1->total_price = 525;
        $detail1->item_id = 2;
        $detail1->location_id = 1;
        $detail1->purchase_id = $purchase1->id;
        $detail1->save();      
        

        ////////////////////////////////////////////////////////////////
        
        $purchase2 = new Purchase;
        $purchase2->local_purchase = 1;
        $purchase2->total_amount = 100;
        $purchase2->user_id = $user->id;
        $purchase2->purchase_invoice_no = time() . '1p';
        $purchase2->save();


        $detail1 = new PurchaseDetail;
        $detail1->price = 100;
        $detail1->quantity = 8;
        $detail1->total_price = 800;
        $detail1->item_id = 2;
        $detail1->location_id = 1;
        $detail1->purchase_id = $purchase2->id;
        $detail1->save();

        $detail1 = new PurchaseDetail;
        $detail1->price = 20;
        $detail1->quantity = 10;
        $detail1->total_price = 200;
        $detail1->item_id = 2;
        $detail1->location_id = 2;
        $detail1->purchase_id = $purchase2->id;
        $detail1->save();      
        
        ////////////////////////////////////////////////////////////////
        
        $purchase3 = new Purchase;
        $purchase3->local_purchase = 0;
        $purchase3->total_amount = 2500;
        $purchase3->user_id = $user->id;
        $purchase3->purchase_invoice_no = time() . '2p';
        $purchase3->save();


        $detail1 = new PurchaseDetail;
        $detail1->price = 100;
        $detail1->quantity = 10;
        $detail1->total_price = 1000;
        $detail1->item_id = 3;
        $detail1->location_id = 1;
        $detail1->purchase_id = $purchase3->id;
        $detail1->save();

        $detail1 = new PurchaseDetail;
        $detail1->price = 25;
        $detail1->quantity = 10;
        $detail1->total_price = 250;
        $detail1->item_id = 4;
        $detail1->location_id = 2;
        $detail1->purchase_id = $purchase3->id;
        $detail1->save();              

    }
}
