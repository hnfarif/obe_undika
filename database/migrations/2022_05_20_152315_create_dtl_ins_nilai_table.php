<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtlInsNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtl_ins_nilai', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ins_nilai_id')->unsigned();
            $table->bigInteger('clo_id')->unsigned();
            $table->bigInteger('penilaian_id')->unsigned();
            $table->bigInteger('mhs_nim')->unsigned();
            $table->integer('nilai')->unsigned();

            $table->foreign('ins_nilai')->references('id')->on('instrumen_nilai')->onDelete('cascade');
            $table->foreign('clo_id')->references('id')->on('clo')->onDelete('cascade');
            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
            $table->foreign('mhs_nim')->references('nim')->on('mhs_mf')->onDelete('cascade');
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
        Schema::dropIfExists('dtl_ins_nilai');
    }
}
