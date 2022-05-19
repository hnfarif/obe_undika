<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJdwkulMfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jdwkul_mf', function (Blueprint $table) {

            $table->string('kary_nik', 6);
            $table->string('klkl_id', 10);
            $table->string('kelas', 2)->nullable();
            $table->integer('hari')->nullable();
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->integer('terisi')->nullable();
            $table->integer('isi_temp')->nullable();
            $table->string('sts_kul',1);
            $table->string('sts_info',1)->nullable();
            $table->string('ruang_id',5);
            $table->string('prodi',5);
            $table->integer('sks');
            $table->integer('kd_agm')->nullable();

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
        Schema::dropIfExists('jdwkul_mf');
    }
}
