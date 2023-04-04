<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsTfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs_tf', function (Blueprint $table) {

            $table->string('jkul_kelas', 2);
            $table->string('jkul_klkl_id', 10);
            $table->string('kary_nik', 6);
            $table->string('mhs_nim', 11);
            $table->string('sts_pre', 1)->nullable();

            $table->foreign('mhs_nim')->references('nim')->on('mhs_mf')->onDelete('cascade');
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
        Schema::dropIfExists('krs_tf');
    }
}
