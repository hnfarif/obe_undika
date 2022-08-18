<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAngketTfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angket_tf', function (Blueprint $table) {
            $table->string('nik', 11);
            $table->string('kode_mk', 11);
            $table->string('kelas', 6);
            $table->char('smt', 3);
            $table->char('smt_mk', 3);
            $table->bigInteger('kd_angket')->nullable();
            $table->decimal('nilai', 6, 2)->nullable();
            $table->string('prodi', 5);

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
        Schema::dropIfExists('angket_tf');
    }
}
