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
        Schema::create('baca_onlines', function (Blueprint $table) {
            $table->increments('id_baca_online');
            $table->integer('id_dbuku');
            $table->integer('id_usr');
            $table->dateTime('tgl_mulai_baca')->nullable();
            $table->dateTime('tgl_selesai_baca')->nullable();
            $table->tinyInteger('status_baca')->default(1);
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
        Schema::dropIfExists('baca_onlines');
    }
};
