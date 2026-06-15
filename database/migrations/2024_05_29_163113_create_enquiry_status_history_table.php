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
        Schema::create('enquiry_status_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('enquiry_id')->nullable()->unsigned();
            $table->foreign('enquiry_id')->references('id')->on('enquiries')->onDelete('set null');
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('note')->nullable();
            $table->string('action_by')->nullable();
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
        Schema::dropIfExists('enquiry_status_history');
    }
};
