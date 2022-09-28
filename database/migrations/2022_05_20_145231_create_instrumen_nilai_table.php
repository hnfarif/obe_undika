<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumenNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumen_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('klkl_id', 10);
            $table->string('nik', 6)->nullable();
            $table->bigInteger('rps_id')->unsigned();
            $table->string('semester', 3);
            $table->string('kelas')->nullable();
            $table->integer('nilai_min_mk')->unsigned()->nullable();

            $table->foreign('rps_id')->references('id')->on('rps')->onDelete('cascade');
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
        Schema::dropIfExists('instrumen_nilai');
    }
}
