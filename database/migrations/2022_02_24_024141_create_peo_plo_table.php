<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoPloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peo_plo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('peo_id')->unsigned();
            $table->bigInteger('plo_id')->unsigned();
            $table->foreign('peo_id')->references('id')->on('peo')->onDelete('cascade');
            $table->foreign('plo_id')->references('id')->on('plo')->onDelete('cascade');
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
        Schema::dropIfExists('peo_plo');
    }
}
