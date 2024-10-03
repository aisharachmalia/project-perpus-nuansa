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
            Schema::create('trks_riwayat_buku', function (Blueprint $table) {
                $table->increments('id_trwyt');
                $table->integer('id_dbuku');
                $table->integer('id_trks');
                $table->dateTime('trwyt_tanggal');
                $table->string('trwyt_jenis');
                $table->timestamps();
                $table->softDeletes();
            });
        }

    
        public function down()
        {
            Schema::dropIfExists('trks_riwayat_buku');
        }
};
