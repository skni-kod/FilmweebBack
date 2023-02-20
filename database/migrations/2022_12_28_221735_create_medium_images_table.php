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
        Schema::create('medium_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medium_id');
            $table->string('image_path', 64)->nullable();
            $table->timestamps();

            $table->foreign('medium_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medium_images');
    }
};
