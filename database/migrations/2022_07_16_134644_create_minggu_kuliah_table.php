<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMingguKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minggu_kuliah', function (Blueprint $table) {
            $table->string('jenis_smt', 1)->nullable();
            $table->string('smt', 3)->nullable();
            $table->integer('minggu_ke')->nullable();
            $table->date('tgl_awal')->nullable();
            $table->date('tgl_akhir')->nullable();

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
        Schema::dropIfExists('minggu_kuliah');
    }
}
