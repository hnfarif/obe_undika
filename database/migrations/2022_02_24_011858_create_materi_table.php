<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agd_id')->unsigned();
            $table->string('nama',100);
            $table->string('jdl_ptk',100);
            $table->string('bab_ptk',20);
            $table->string('hal_ptk',20);
            $table->string('media_bljr',100);
            $table->string('mtd_bljr',100);
            $table->string('kode_pbm',6);
            $table->string('deskripsi_pbm',100);
            $table->string('status');

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
        Schema::dropIfExists('materi');
    }
}
