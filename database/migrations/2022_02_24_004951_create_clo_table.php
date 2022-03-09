<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rps_id')->unsigned();
            $table->string('kode_clo',6);
            $table->text('deskripsi');
            $table->string('ranah_capai');
            $table->string('lvl_bloom');
            $table->integer('tgt_lulus')->nullable();
            $table->integer('nilai_min')->nullable();

            $table->foreign('rps_id')->references('id')->on('rps')->onDelete('cascade');
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
        Schema::dropIfExists('clo');
    }
}
