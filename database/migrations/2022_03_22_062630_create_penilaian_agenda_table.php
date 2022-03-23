<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_agenda', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penilaian_id')->unsigned();
            $table->bigInteger('agdbljr_id')->unsigned();

            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
            $table->foreign('agdbljr_id')->references('id')->on('agd_bljr')->onDelete('cascade');

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
        Schema::dropIfExists('penilaian_agenda');
    }
}
