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
        Schema::create('company_medium', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medium_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('medium_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('production_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_medium');
    }
};
