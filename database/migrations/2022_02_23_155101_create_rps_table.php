<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rps', function (Blueprint $table) {
            $table->id();
            $table->string('kurlkl_id', 10);
            $table->string('nik', 6);
            $table->string('nama_mk',100);
            $table->text('deskripsi_mk')->nullable();
            $table->string('rumpun_mk',50);
            $table->string('ketua_rumpun',50);
            $table->string('penyusun',50)->nullable();
            $table->string('email_penyusun',50)->nullable();
            $table->string('semester',1);
            $table->integer('sks');
            $table->string('file_rps')->nullable();
            $table->char('status',1)->nullable();

            $table->foreign('kurlkl_id')->references('id')->on('kurlkl_mf')->onDelete('cascade');
            $table->foreign('nik')->references('nik')->on('kar_mf')->onDelete('cascade');
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
        Schema::dropIfExists('rps');
    }
}
