<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plo', function (Blueprint $table) {
            $table->id();
            $table->string('fakul_id',5)->nullable();
            $table->string('kode_plo',6);
            $table->text('deskripsi');

            $table->foreign('fakul_id')->references('id')->on('fak_mf')->onDelete('cascade');
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
        Schema::dropIfExists('plo');
    }
}
