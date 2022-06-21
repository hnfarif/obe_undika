<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plot_monev', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ins_nilai_id')->unsigned();
            $table->string('nik_pemonev', 6);
            $table->string('nik_pengajar', 6);
            $table->string('klkl_id', 4);
            $table->string('prodi', 5);

            $table->foreign('ins_nilai_id')->references('id')->on('instrumen_nilai')->onDelete('cascade');
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
        Schema::dropIfExists('plot_monev');
    }
}
