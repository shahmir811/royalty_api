<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_note_no')->unique();
            // $table->double('avg_price', 10, 2);
            // $table->double('sale_price', 10, 2);
            // $table->integer('quantity');     
            // $table->tinyInteger('is_completed')->default(0); // if 0, mean item are reamining to deliver
            // $table->integer('remaining_quantity');    
            
            $table->foreignId('sale_id');
            // $table->foreignId('sale_detail_id');
            // $table->foreignId('location_id');
            // $table->foreignId('inventory_id');

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');   
            // $table->foreign('sale_detail_id')->references('id')->on('sale_details')->onDelete('cascade');   
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');   
            // $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_notes');

    }
}
