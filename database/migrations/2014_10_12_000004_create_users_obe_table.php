<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersObeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_obe', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 6)->nullable();
            $table->string('pin')->nullable();
            $table->string('role')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('kar_mf')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_obe');
    }
}
