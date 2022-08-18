<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrilianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brilian_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brilian_week_id');
            $table->string('nik');
            $table->string('kode_mk');
            $table->string('kelas');
            $table->string('prodi');
            $table->decimal('nilai',6,2);

            $table->foreign('brilian_week_id')->references('id')->on('brilian_week')->onDelete('cascade');
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
        Schema::dropIfExists('brilian_detail');
    }
}
