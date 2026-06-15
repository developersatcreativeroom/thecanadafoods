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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->string('order_unique_id')->nullable();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('vendor_id')->nullable()->unsigned()->comment('In case of multi-vendor');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            
            // from stripe migration start
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            // from stripe migration ends

            $table->string('order_status')->nullable();
            $table->boolean('is_payment_done')->default(0)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_iso_code')->nullable();
            $table->string('discount')->nullable();

            $table->boolean('local_pickup')->default(0)->nullable();
            
            $table->bigInteger('coupon_id')->nullable()->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
            $table->string('coupon_code')->nullable();
            $table->string('coupon_type')->nullable();
            $table->string('coupon_value')->nullable();
            $table->decimal('coupon_discount', 8, 2)->nullable();

            $table->string('order_type')->nullable(); 
            $table->string('customer_gst')->nullable(); 
            $table->string('order_notes')->nullable(); 
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
        Schema::dropIfExists('orders');
    }
};
