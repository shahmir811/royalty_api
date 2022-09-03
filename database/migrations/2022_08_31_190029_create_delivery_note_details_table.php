<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNoteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_note_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_note_id');
            $table->foreignId('location_id');
            $table->foreignId('inventory_id');  
            $table->foreignId('sale_id');  
            $table->integer('quantity');
            
            $table->timestamps();
            
            $table->foreign('delivery_note_id')->references('id')->on('delivery_notes')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_note_details');
    }
}
