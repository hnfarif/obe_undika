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
            $table->string('kary_type', 2)->nullable();
            $table->string('nama', 50);
            $table->string('fakul_id', 5);
            $table->string('nip', 15)->nullable();
            $table->char('status', 1)->nullable();
            $table->unsignedInteger('bagian')->nullable();
            $table->unsignedInteger('absensi')->nullable();
            $table->string('pin')->nullable();
            $table->string('manager_id', 6)->nullable();
            $table->date('mulai_kerja')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->string('inisial', 3)->nullable();
            $table->unsignedInteger('kode_sie')->nullable();
            $table->unsignedInteger('adm')->nullable();
            $table->unsignedInteger('dosen')->nullable();
            $table->string('gelar_depan', 20)->nullable();
            $table->string('gelar_belakang', 80)->nullable();
            $table->string('pin_b', 50)->nullable();
            $table->string('ktp', 30)->nullable();
            $table->string('kk', 30)->nullable();
            $table->string('nidk', 15)->nullable();
            $table->string('nup', 15)->nullable();
            $table->timestamps();

            $table->foreign('fakul_id')->references('id')->on('fak_mf')->onDelete('cascade');
            $table->foreign('bagian')->references('kode')->on('bagian1')->onDelete('cascade');

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
