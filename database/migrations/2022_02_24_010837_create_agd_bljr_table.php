<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgdBljrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agd_bljr', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rps_id')->unsigned();
            $table->string('minggu',13);
            $table->string('btk_penilaian',100);
            $table->integer('bbt_penilaian');
            $table->text('deskripsi_penilaian');
            $table->string('kajian',50);
            $table->integer('tatapmuka');
            $table->integer('sl');
            $table->integer('al');
            $table->integer('assessment');
            $table->integer('res_tutor');
            $table->integer('bljr_mandiri');
            $table->integer('praktikum');

            $table->foreign('rps_id')->references('id')->on('rps')->onDelete('cascade');
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
        Schema::dropIfExists('agd_bljr');
    }
}
