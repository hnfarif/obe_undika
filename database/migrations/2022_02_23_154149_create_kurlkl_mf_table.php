<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurlklMfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurlkl_mf', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('prasyarat')->nullable();
            $table->string('semester', 1);
            $table->string('nama', 50);
            $table->integer('sks');
            $table->char('status',1);
            $table->string('sinonim',100)->nullable();
            $table->string('fakul_id',5);
            $table->string('nama_ing', 75)->nullable();
            $table->integer('jenis');
            $table->string('tahun',4);
            $table->integer('sts_sertifikasi')->nullable();
            $table->integer('prioritas')->nullable();
            $table->string('sts_konversi',0)->nullable();
            $table->string('sts_pra',1)->nullable();
            $table->string('min_nilai',2);
            $table->string('kompetensi',0)->nullable();
            $table->string('jenis_wajib',0)->nullable();
            $table->string('koordinator',0)->nullable();
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
        Schema::dropIfExists('kurlkl_mf');
    }
}
