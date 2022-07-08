<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtlInsMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtl_ins_monev', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ins_monev_id')->unsigned();
            $table->bigInteger('dtl_agd_id')->unsigned();
            $table->bigInteger('id_kri')->unsigned();
            $table->integer('nilai')->unsigned()->nullable();

            $table->foreign('ins_monev_id')->references('id')->on('instrumen_monev')->onDelete('cascade');
            $table->foreign('dtl_agd_id')->references('id')->on('dtl_agd')->onDelete('cascade');
            $table->foreign('id_kri')->references('id')->on('kri_monev')->onDelete('cascade');
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
        Schema::dropIfExists('dtl_ins_monev');
    }
}
