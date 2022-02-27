<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePloCloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plo_clo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plo_id')->unsigned();
            $table->bigInteger('clo_id')->unsigned();
            $table->foreign('plo_id')->references('id')->on('plo')->onDelete('cascade');
            $table->foreign('clo_id')->references('id')->on('clo')->onDelete('cascade');
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
        Schema::dropIfExists('plo_clo');
    }
}
