<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgdBljrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agd_bljr', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rps_id')->unsigned();
            $table->string('pekan',3);
            $table->date('tgl_nilai')->nullable();
            $table->string('status',1)->nullable();

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
        Schema::dropIfExists('agd_bljr');
    }
}
