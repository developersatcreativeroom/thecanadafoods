<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_log_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventory_log_id')->nullable()->unsigned();
            $table->foreign('inventory_log_id')->references('id')->on('inventory_logs')->onDelete('set null');
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->bigInteger('product_attribute_id')->nullable()->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');
            $table->integer('quantity');
            $table->decimal('product_price', 8, 2)->nullable();
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
        Schema::dropIfExists('inventory_log_products');
    }
};
