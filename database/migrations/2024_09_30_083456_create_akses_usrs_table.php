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
        Schema::create('akses_usrs', function (Blueprint $table) {
            $table->increments('id_akses');
            $table->integer('id_usr');
            $table->integer('id_role');
            $table->integer('id_menu');
            $table->tinyInteger('hak_akses')->default(0);
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
        Schema::dropIfExists('akses_usrs');
    }
};
