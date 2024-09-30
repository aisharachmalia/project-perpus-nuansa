<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_usr');
            $table->string('usr_nama');
            $table->string('usr_username')->unique();
            $table->string('usr_email')->unique();
            $table->string('password');
            $table->tinyInteger('usr_stat')->default(0);
            $table->dateTime('email_verified')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('kode_otp')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
