<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peo', function (Blueprint $table) {
            $table->id();
            $table->string('fakul_id',5);
            $table->string('kode_peo',6);
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
        Schema::dropIfExists('peo');
    }
}
