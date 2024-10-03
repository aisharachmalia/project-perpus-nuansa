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
        Schema::create('dm_kelas', function (Blueprint $table) {
            $table->increments('id_dkelas');
            $table->string('dkelas_nama_kelas');
            $table->string('dkelas_tingkat');
            $table->string('dkelas_jurusan');
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
        Schema::dropIfExists('dm_kelas');
    }
};
