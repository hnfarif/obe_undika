<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtlAgdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtl_agd', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agd_id')->unsigned();
            $table->bigInteger('clo_id')->unsigned();
            $table->bigInteger('llo_id')->unsigned()->nullable();
            $table->bigInteger('penilaian_id')->unsigned()->nullable();
            $table->integer('bobot')->nullable();
            $table->text('capaian_llo')->nullable();
            $table->text('deskripsi_penilaian')->nullable();

            $table->integer('tm')->nullable();
            $table->integer('sl')->nullable();
            $table->integer('asl')->nullable();
            $table->integer('asm')->nullable();
            $table->integer('res_tutor')->nullable();
            $table->integer('bljr_mandiri')->nullable();
            $table->integer('praktikum')->nullable();
            $table->date('tgl_nilai')->nullable();


            $table->foreign('agd_id')->references('id')->on('agd_bljr')->onDelete('cascade');
            $table->foreign('clo_id')->references('id')->on('clo')->onDelete('cascade');
            $table->foreign('llo_id')->references('id')->on('llo')->onDelete('cascade');
            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');

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
        Schema::dropIfExists('dtl_agd');
    }
}
