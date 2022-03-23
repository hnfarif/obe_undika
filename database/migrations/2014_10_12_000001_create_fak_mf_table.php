<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakMfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fak_mf', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('nama', 50);
            $table->char('status', 1);
            $table->string('jurusan', 50);
            $table->string('prodi_ing', 50)->nullable();
            $table->string('jurusan_ing', 50)->nullable();
            $table->string('mngr_id', 6);
            $table->string('alias', 10)->nullable();
            $table->integer('sks_tempuh')->nullable();
            $table->string('sts_aktif',1);
            $table->integer('id_fakultas');
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
        Schema::dropIfExists('fak_mf');
    }
}
