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
        Schema::create('order_shipment_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->string('state_to')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_iso_code')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('order_shipment_details');
    }
};
