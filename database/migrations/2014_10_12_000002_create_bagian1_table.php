<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagian1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bagian1', function (Blueprint $table) {
            $table->integer('kode')->primary()->unsigned();
            $table->string('nick', 8)->nullable();
            $table->string('nama', 35);
            $table->string('manager_id', 6)->nullable();
            $table->string('puket', 6)->nullable();
            $table->string('sts', 1)->nullable();


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
        Schema::dropIfExists('bagian1');
    }
}
