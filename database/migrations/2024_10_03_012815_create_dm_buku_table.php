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
        Schema::create('dm_buku', function (Blueprint $table) {
            $table->increments('id_dbuku');
            $table->string('dbuku_cover')->nullable();
            $table->string('dbuku_judul');
            $table->integer('id_dpenulis');
            $table->integer('id_dpenerbit');
            $table->integer('id_dkategori')->nullable();
            $table->integer('id_dmapel')->nullable();
            $table->string('dbuku_thn_terbit');
            $table->string('dbuku_isbn')->unique();
            $table->integer('dbuku_jml_tersedia')->default(0);
            $table->integer('dbuku_jml_total')->default(0);
            $table->string('dbuku_lokasi_rak');
            $table->integer('dbuku_edisi');
            $table->string('dbuku_bahasa');
            $table->tinyInteger('dbuku_status')->default(1);
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
        Schema::dropIfExists('dm_buku');
    }
};
