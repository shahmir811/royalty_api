<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_histories', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('status'); // MOVE_IN, MOVE_OUT, PURCHASE, SALE
            $table->integer('quantity');
            
            $table->string('purchased_invoice_no')->nullable();
            $table->string('sale_invoice_no')->nullable();
            $table->string('action_performer'); // User who performed the action
            $table->foreignId('inventory_id');

            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

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
        Schema::dropIfExists('inventory_item_histories');
    }
}
