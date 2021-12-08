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
            $table->double('cbm', 6, 2);
            $table->double('weight', 6, 2);
            $table->double('purchase_price', 10, 2);
            $table->double('avg_price', 10, 2);
            $table->double('sale_price', 10, 2);           
            
            $table->foreignId('location_id');
            $table->softDeletes();
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
