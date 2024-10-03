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
        Schema::create('dm_gurus', function (Blueprint $table) {
            $table->increments('id_dguru');
            $table->string('dguru_nama');
            $table->string('dguru_nip')->unique();
            $table->string('dguru_email')->unique();
            $table->string('dguru_no_telp')->unique();
            $table->string('dguru_alamat')->nullable();
            $table->integer('id_mapel');
            $table->tinyInteger('dguru_status')->default(1);
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
        Schema::dropIfExists('dm_gurus');
    }
};
