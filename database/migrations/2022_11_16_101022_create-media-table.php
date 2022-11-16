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
        Schema::create('media', function (Blueprint $table){
           $table->increments('id');
           $table->string('title', 64);
           $table->string('original_title', 64);
           $table->date('release_date');
           $table->string('overview', 64);
           $table->double('duration');
           $table->enum('type', ['movie', 'serie']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
};
