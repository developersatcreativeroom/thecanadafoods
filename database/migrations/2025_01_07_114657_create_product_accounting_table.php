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
        Schema::create('product_accounting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->bigInteger('product_attribute_id')->nullable()->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');
            $table->string('accounting_software')->nullable();
            $table->string('product_code')->nullable()->comment('Unique product identifier, in Xero, ItemCode');
            $table->boolean('is_synchronized')->default(0)->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('product_accounting');
    }
};
