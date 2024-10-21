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
        Schema::create('trks_transaksi', function (Blueprint $table) {
            $table->increments('id_trks');
            $table->integer('id_dbuku');
            $table->integer('id_dsbuku');
            $table->integer('id_usr');
            $table->integer('id_dsiswa');
            $table->integer('id_dpustakawan');
            $table->dateTime('trks_tgl_peminjaman')->nullable();
            $table->dateTime('trks_tgl_jatuh_tempo')->nullable();
            $table->dateTime('trks_tgl_pengembalian')->nullable();
            $table->double('trks_denda');
            $table->tinyInteger('trks_status')->default(0);
            $table->text('trks_keterangan')->nullable();
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
        Schema::dropIfExists('trks_transaksi');
    }
};
