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
        Schema::create('cart_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id')->nullable()->unsigned();
            $table->foreign('cart_id')->references('id')->on('cart')->onDelete('cascade');
            $table->bigInteger('product_service_id')->nullable()->unsigned();
            $table->foreign('product_service_id')->references('id')->on('product_services')->onDelete('cascade');
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
        Schema::dropIfExists('cart_services');
    }
};
