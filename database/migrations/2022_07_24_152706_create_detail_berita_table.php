<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_berita', function (Blueprint $table) {
            $table->string('kode_bap', 15);
            $table->string('kelas', 2);
            $table->char('semester', 3);
            $table->string('nik', 6);
            $table->string('realisasi', 500);
            $table->string('catatan', 300)->nullable();
            $table->string('nim_sah', 11)->nullable();
            $table->date('waktu_entry');
            $table->string('prodi', 5);
            $table->string('prk_group', 6)->nullable();
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
        Schema::dropIfExists('detail_berita');
    }
}
