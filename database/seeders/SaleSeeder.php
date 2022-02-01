<?php

namespace Database\Seeders;

use Auth;
use App\Models\{User, Sale, SaleDetail };
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = User::findOrFail(3);


        ///////////////////////////////////////////////////////////////////////////////////////////

        $sale1                       = new Sale;
        $sale1->total_sale_price     = 2500;
        $sale1->total_avg_price      = 2375;
        $sale1->extra_charges        = 500;
        $sale1->total_tax            = 50;
        $sale1->tax_percent          = 2;
        $sale1->contact_no           = '+971 513 125365';
        $sale1->shipping_location    = $faker->address();
        $sale1->type                 = 'local';
        $sale1->quotation            = 0;
        $sale1->user_id              = $user->id;
        $sale1->customer_id          = 1;
        $sale1->save();

        ///////////////////////////////////
        $detail1                     = new SaleDetail;
        $detail1->avg_price          = 95;
        $detail1->sale_price         = 100;
        $detail1->quantity           = 25;
        
        $detail1->total_avg_price    = 95 * 25;
        $detail1->total_sale_price   = 100 * 25;
        
        $detail1->location_id        = 3;
        $detail1->inventory_id       = 2;
        $detail1->sale_id            = $sale1->id;
        $detail1->save();          
        
        
        ///////////////////////////////////////////////////////////////////////////////////////////

        $sale2                       = new Sale;
        $sale2->total_sale_price     = 1854;
        $sale2->total_avg_price      = 1815;
        $sale2->extra_charges        = 315;
        $sale2->total_tax            = 92.5;
        $sale2->tax_percent          = 5;
        $sale2->contact_no           = '+971 321 3625145';
        $sale2->shipping_location    = $faker->address();
        $sale2->type                 = 'local';
        $sale2->quotation            = 0;
        $sale2->user_id              = $user->id;
        $sale2->customer_id          = 2;
        $sale2->created_at           =  time() + 2;
        $sale2->save();

        ///////////////////////////////////
        $detail1                     = new SaleDetail;
        $detail1->avg_price          = 86;
        $detail1->sale_price         = 87;
        $detail1->quantity           = 10;
        
        $detail1->total_avg_price    = 86 * 10;
        $detail1->total_sale_price   = 87 * 10;
        
        $detail1->location_id        = 1;
        $detail1->inventory_id       = 5;
        $detail1->sale_id            = $sale2->id;
        $detail1->save();      
        
        ///////////////////////////////////
        $detail2                     = new SaleDetail;
        $detail2->avg_price          = 100;
        $detail2->sale_price         = 103;
        $detail2->quantity           = 5;
        
        $detail2->total_avg_price    = 100 * 5;
        $detail2->total_sale_price   = 103 * 5;
        
        $detail2->location_id        = 2;
        $detail2->inventory_id       = 4;
        $detail2->sale_id            = $sale2->id;
        $detail2->save();      
        
        ///////////////////////////////////
        $detail3                     = new SaleDetail;
        $detail3->avg_price          = 65;
        $detail3->sale_price         = 67;
        $detail3->quantity           = 7;
        
        $detail3->total_avg_price    = 67 * 7;
        $detail3->total_sale_price   = 65 * 7;
        
        $detail3->location_id        = 3;
        $detail3->inventory_id       = 10;
        $detail3->sale_id            = $sale2->id;
        $detail3->save();      
         

        ///////////////////////////////////////////////////////////////////////////////////////////        


        $sale3                       = new Sale;
        $sale3->total_sale_price     = 1180;
        $sale3->total_avg_price      = 1116;
        $sale3->extra_charges        = 250;
        $sale3->total_tax            = 0;
        $sale3->tax_percent          = 0;
        $sale3->contact_no           = '+971 513 125365';
        $sale3->shipping_location    = $faker->address();
        $sale3->type                 = 'export';
        $sale3->quotation            = 0;
        $sale3->user_id              = $user->id;
        $sale3->customer_id          = 3;
        $sale3->created_at           =  time() + 3;
        $sale3->save();

        ///////////////////////////////////
        $detail1                     = new SaleDetail;
        $detail1->avg_price          = 53;
        $detail1->sale_price         = 55;
        $detail1->quantity           = 10;
        
        $detail1->total_avg_price    = 53 * 10;
        $detail1->total_sale_price   = 55 * 10;
        
        $detail1->location_id        = 2;
        $detail1->inventory_id       = 6;
        $detail1->sale_id            = $sale3->id;
        $detail1->save();      
        
        ///////////////////////////////////
        $detail2                     = new SaleDetail;
        $detail2->avg_price          = 29;
        $detail2->sale_price         = 35;
        $detail2->quantity           = 5;
        
        $detail2->total_avg_price    = 29 * 5;
        $detail2->total_sale_price   = 35 * 5;
        
        $detail2->location_id        = 3;
        $detail2->inventory_id       = 7;
        $detail2->sale_id            = $sale3->id;
        $detail2->save();      
        
        ///////////////////////////////////
        $detail3                     = new SaleDetail;
        $detail3->avg_price          = 63;
        $detail3->sale_price         = 65;
        $detail3->quantity           = 7;
        
        $detail3->total_avg_price    = 63 * 7;
        $detail3->total_sale_price   = 65 * 7;
        
        $detail3->location_id        = 3;
        $detail3->inventory_id       = 8;
        $detail3->sale_id            = $sale3->id;
        $detail3->save();       
        
        
        ///////////////////////////////////////////////////////////////////////////////////////////        


        $sale4                       = new Sale;
        $sale4->total_sale_price     = 1821;
        $sale4->total_avg_price      = 1851;
        $sale4->extra_charges        = 450;
        $sale4->total_tax            = 36.42;
        $sale4->tax_percent          = 2;
        $sale4->contact_no           = '+971 513 125365';
        $sale4->shipping_location    = $faker->address();
        $sale4->type                 = 'export';
        $sale4->quotation            = 1;
        $sale4->user_id              = $user->id;
        $sale4->customer_id          = 1;
        $sale4->created_at           = time() + 4;
        $sale4->save();

        ///////////////////////////////////
        $detail1                     = new SaleDetail;
        $detail1->avg_price          = 105.5;
        $detail1->sale_price         = 105.5;
        $detail1->quantity           = 10;
        
        $detail1->total_avg_price    = 105.5 * 10;
        $detail1->total_sale_price   = 105.5 * 10;
        
        $detail1->location_id        = 1;
        $detail1->inventory_id       = 1;
        $detail1->sale_id            = $sale4->id;
        $detail1->save();      
        
        ///////////////////////////////////
        $detail2                     = new SaleDetail;
        $detail2->avg_price          = 71;
        $detail2->sale_price         = 72;
        $detail2->quantity           = 5;
        
        $detail2->total_avg_price    = 71 * 5;
        $detail2->total_sale_price   = 72 * 5;
        
        $detail2->location_id        = 2;
        $detail2->inventory_id       = 9;
        $detail2->sale_id            = $sale4->id;
        $detail2->save();      
        
        ///////////////////////////////////
        $detail3                     = new SaleDetail;
        $detail3->avg_price          = 63;
        $detail3->sale_price         = 58;
        $detail3->quantity           = 7;
        
        $detail3->total_avg_price    = 63 * 7;
        $detail3->total_sale_price   = 58 * 7;
        
        $detail3->location_id        = 3;
        $detail3->inventory_id       = 8;
        $detail3->sale_id            = $sale4->id;
        $detail3->save();              



    }
}
