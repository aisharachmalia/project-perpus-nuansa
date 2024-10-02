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
        Schema::create('trks_denda', function (Blueprint $table) {
            $table->increments('id_tdenda'); // AUTO_INCREMENT PRIMARY KEY
            $table->integer('id_trks');
            $table->double('tdenda_jumlah');
            $table->dateTime('tdenda_tgl_bayar')->nullable();
            $table->string('tdenda_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trks_denda');
    }
};
