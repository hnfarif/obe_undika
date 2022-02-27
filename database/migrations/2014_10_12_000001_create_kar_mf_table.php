<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKarMfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kar_mf', function (Blueprint $table) {
            $table->string('nik', 6)->primary();
            $table->string('kary_type', 2);
            $table->string('nama', 50);
            $table->string('alamat', 100);
            $table->string('kot_id', 4)->nullable();
            $table->unsignedInteger('sex');
            $table->unsignedInteger('sts_marital');
            $table->unsignedInteger('wn');
            $table->unsignedInteger('agama');
            $table->string('shift', 1);
            $table->string('fakul_id', 5)->nullable();
            $table->string('nip', 15);
            $table->string('telp', 50);
            $table->char('status', 1);
            $table->unsignedInteger('bagian');
            $table->unsignedInteger('absensi');
            $table->string('pin', 6);
            $table->string('sts_pin', 1);
            $table->string('manager_id', 6);
            $table->date('mulai_kerja');
            $table->date('tgl_keluar');
            $table->string('kelompok', 15);
            $table->string('inisial', 3);
            $table->unsignedInteger('kode_sie');
            $table->unsignedInteger('adm');
            $table->unsignedInteger('dosen');
            $table->string('gelar_depan', 20);
            $table->string('gelar_belakang', 80);
            $table->string('pin_b', 50);
            $table->string('ktp', 30);
            $table->string('kk', 30);
            $table->string('nidk', 15);
            $table->string('nup', 15);
            $table->timestamps();

            $table->foreign('fakul_id')->references('id')->on('fak_mf')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kar_mf');
    }
}
