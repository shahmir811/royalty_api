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
            $table->string('sales_invoice_no')->unique();
            $table->double('total_sales_price', 10, 2);
            $table->double('total_tax', 10, 2);
            $table->double('total_cost_price', 10, 2);
            $table->integer('tax_percent');
            $table->string('contact_no');
            $table->text('shipping_location');
            $table->string('type'); // type means local / export
            $table->boolean('quotation');

            $table->foreignId('user_id');
            $table->foreignId('statuses_id');
            $table->foreignId('customer_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('statuses_id')->references('id')->on('statuses')->onDelete('cascade');  
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
