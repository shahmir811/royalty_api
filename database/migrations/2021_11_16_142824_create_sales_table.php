<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_invoice_no')->nullable();
            $table->tinyInteger('proper_invoice')->default(0); // if 1 than proper invoice else improper
            $table->double('total_sale_price', 10, 2);
            $table->double('total_tax', 10, 2);
            $table->double('total_avg_price', 10, 2);
            $table->double('extra_charges', 10, 2);
            $table->double('tax_percent', 10, 2);
            $table->string('contact_no');
            $table->text('shipping_location');
            $table->string('type'); // type means local / export
            $table->boolean('quotation');

            $table->foreignId('user_id');
            $table->foreignId('status_id');
            $table->foreignId('customer_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');  
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
