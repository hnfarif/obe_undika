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
            $table->string('penyusun',50)->nullable();
            $table->string('email_penyusun',50)->nullable();
            $table->string('semester',3);
            $table->string('file_rps')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_done')->default(0);

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
