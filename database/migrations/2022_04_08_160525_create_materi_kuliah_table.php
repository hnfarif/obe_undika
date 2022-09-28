<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi_kuliah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dtl_agd_id')->unsigned();

            $table->string('kajian')->nullable();
            $table->string('materi')->nullable();
            $table->string('jdl_ptk')->nullable();
            $table->string('bab_ptk')->nullable();
            $table->string('hal_ptk')->nullable();
            $table->string('media_bljr')->nullable();
            $table->string('mtd_bljr')->nullable();
            $table->string('deskripsi_pbm')->nullable();
            $table->string('status')->nullable();

            $table->foreign('dtl_agd_id')->references('id')->on('dtl_agd')->onDelete('cascade');
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
        Schema::dropIfExists('materi_kuliah');
    }
}
