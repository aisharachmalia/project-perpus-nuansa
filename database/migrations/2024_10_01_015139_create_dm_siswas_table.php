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
        Schema::create('dm_siswas', function (Blueprint $table) {
            $table->increments('id_dsiswa');
            $table->string('dsiswa_nama');
            $table->string('dsiswa_nis')->unique();
            $table->string('dsiswa_email')->unique();
            $table->string('dsiswa_no_telp')->unique();
            $table->text('dsiswa_alamat')->nullable();
            $table->tinyInteger('dsiswa_sts')->default(1);
            $table->integer('id_dkelas');
            $table->tinyInteger('dsiswa_flag')->default(0);
            $table->integer('id_usr');
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
        Schema::dropIfExists('dm_siswas');
    }
};
