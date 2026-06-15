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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_no')->nullable();
            $table->string('enquiry_unique_id')->nullable();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('vendor_id')->nullable()->unsigned()->comment('In case of multi-vendor');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();

            $table->string('enquiry_status')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_iso_code')->nullable();
            $table->string('discount')->nullable();

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
        Schema::dropIfExists('enquiries');
    }
};
