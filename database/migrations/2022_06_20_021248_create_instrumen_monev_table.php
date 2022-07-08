<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumenMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumen_monev', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plot_monev_id')->unsigned();
            $table->bigInteger('ins_nilai_id')->unsigned();




            $table->foreign('plot_monev_id')->references('id')->on('plot_monev')->onDelete('cascade');
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
        Schema::dropIfExists('instrumen_monev');
    }
}
