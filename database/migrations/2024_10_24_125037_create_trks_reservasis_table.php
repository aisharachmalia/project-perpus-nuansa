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
        Schema::create('trks_reservasis', function (Blueprint $table) {
            $table->increments('id_trsv');
            $table->integer('id_usr');
            $table->integer('id_dbuku');
            $table->integer('id_dsbuku');
            $table->dateTime('trsv_tgl_reservasi')->nullable();
            $table->dateTime('trsv_tgl_kadaluarsa')->nullable();
            $table->dateTime('trsv_tgl_pemberitahuan')->nullable();
            $table->dateTime('trsv_tgl_pengambilan')->nullable();
            $table->tinyInteger('trsv_status')->default(1);
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
        Schema::dropIfExists('trks_reservasis');
    }
};
