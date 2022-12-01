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
        Schema::create('language_language_role_medium', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medium_id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('language_role_id');

            $table->foreign('medium_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('language_role_id')->references('id')->on('language_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_language_role_medium');
    }
};
