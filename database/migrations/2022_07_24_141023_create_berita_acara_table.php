<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->string('kode_bap', 15);
            $table->string('kode_mk', 10);
            $table->integer('pertemuan');
            $table->string('tujuan', 1000)->nullable();
            $table->string('pokok_bahasan',1000)->nullable();
            $table->date('waktu_entry');
            $table->string('prodi', 5);

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
        Schema::dropIfExists('berita_acara');
    }
}
