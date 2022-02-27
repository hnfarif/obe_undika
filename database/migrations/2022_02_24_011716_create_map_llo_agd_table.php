<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapLloAgdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_llo_agd', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('llo_id')->unsigned();
            $table->bigInteger('agd_id')->unsigned();
            $table->foreign('llo_id')->references('id')->on('llo')->onDelete('cascade');
            $table->foreign('agd_id')->references('id')->on('agd_bljr')->onDelete('cascade');
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
        Schema::dropIfExists('map_llo_agd');
    }
}
