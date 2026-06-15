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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->decimal('total', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('coupon_discount', 8, 2)->nullable();
            $table->decimal('shipping', 8, 2)->nullable();
            $table->decimal('products_service', 8, 2)->nullable();

            $table->boolean('is_state_tax')->nullable();
            $table->boolean('is_central_tax')->nullable();
            $table->boolean('is_integrated_tax')->nullable();
            $table->decimal('tax', 8, 2)->nullable();

            $table->string('currency')->nullable();
            $table->string('currency_iso_code')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('type')->nullable();
            $table->string('payment_status'); 
            $table->string('razorpay_order_id')->nullable()->comment('for razorpay only');

            $table->string('payment_id')->nullable()->comment('response id');
            $table->text('payment_response')->nullable();

            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
