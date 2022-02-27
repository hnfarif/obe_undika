<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloLloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clo_llo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('clo_id')->unsigned();
            $table->bigInteger('llo_id')->unsigned();
            $table->foreign('clo_id')->references('id')->on('clo')->onDelete('cascade');
            $table->foreign('llo_id')->references('id')->on('llo')->onDelete('cascade');
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
        Schema::dropIfExists('clo_llo');
    }
}
