<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKulTfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kul_tf', function (Blueprint $table) {
            $table->string('jkul_kelas', 2);
            $table->string('jkul_kary_nik', 6);
            $table->string('jkul_klkl_id', 10);
            $table->date('tanggal');
            $table->date('j_masuk')->nullable();
            $table->date('j_pulang')->nullable();
            $table->string('sts_hadir',1)->nullable();
            $table->string('ruang_id', 5);
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->string('sts_pintu',1)->nullable();
            $table->string('prodi',5);
            $table->integer('sks');
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
        Schema::dropIfExists('kul_tf');
    }
}
