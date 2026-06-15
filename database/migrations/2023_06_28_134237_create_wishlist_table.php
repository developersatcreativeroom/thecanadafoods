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
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->bigInteger('product_attribute_id')->nullable()->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('uuid')->nullable();
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
        Schema::dropIfExists('wishlist');
    }
};
