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
        Schema::create('dm_penulis', function (Blueprint $table) {
            $table->increments('id_dpenulis');
            $table->string('dpenulis_nama_penulis')->unique();
            $table->string('dpenulis_kewarganegaraan');
            $table->date('dpenulis_tgl_lahir');
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
        Schema::dropIfExists('dm_penulis');
    }
};
