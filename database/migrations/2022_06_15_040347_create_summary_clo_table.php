<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryCloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summary_clo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('clo_id')->unsigned();
            $table->bigInteger('ins_nilai_id')->unsigned();
            $table->text('sbb_gagal')->nullable();
            $table->text('perbaikan')->nullable();

            $table->foreign('clo_id')->references('id')->on('clo')->onDelete('cascade');
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
        Schema::dropIfExists('summary_clo');
    }
}
