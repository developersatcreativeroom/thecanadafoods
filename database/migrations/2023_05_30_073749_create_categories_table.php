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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('title_h1')->nullable();
            $table->integer('parent_category_id')->nullable();
            $table->integer('level')->nullable();
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('is_requested')->nullable();
            $table->integer('requested_by')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->integer('priority')->nullable();
            $table->boolean('is_main_nav')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
};
