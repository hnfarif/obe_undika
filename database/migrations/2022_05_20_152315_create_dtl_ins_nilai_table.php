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
            $table->string('mhs_nim',11);
            $table->bigInteger('dtl_agd_id')->unsigned();
            $table->integer('nilai')->unsigned()->nullable();

            $table->foreign('ins_nilai_id')->references('id')->on('instrumen_nilai')->onDelete('cascade');
            $table->foreign('mhs_nim')->references('nim')->on('mhs_mf')->onDelete('cascade');
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
        Schema::dropIfExists('dtl_ins_nilai');
    }
}
