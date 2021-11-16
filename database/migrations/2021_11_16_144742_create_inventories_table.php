<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->string('package');
            $table->unsignedDecimal('cbm', $precision = 6, $scale = 2);
            $table->unsignedDecimal('weight', $precision = 6, $scale = 2);
            $table->double('purchase_price', 10, 2);
            $table->double('sale_price', 10, 2); // this purchase price will be cost price in sales table            
            
            $table->foreignId('location_id');
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
