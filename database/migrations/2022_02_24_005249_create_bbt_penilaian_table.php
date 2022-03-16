<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbtPenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbt_penilaian', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penilaian_id')->unsigned();
            $table->bigInteger('clo_id')->unsigned();
            $table->integer('bobot')->nullable();
            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
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
        Schema::dropIfExists('bbt_penilaian');
    }
}
