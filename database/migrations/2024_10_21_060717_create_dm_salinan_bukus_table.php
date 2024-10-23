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
        schema::create('dm_salinan_bukus', function (Blueprint $table) {
            $table->increments('id_dsbuku');
            $table->integer('id_dbuku');
            $table->string('dsbuku_no_salinan');
            $table->string('dsbuku_kondisi')->default("Baik");
            $table->tinyInteger('dsbuku_status')->default(0);
            $table->tinyInteger('dsbuku_flag')->default(0);
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
        Schema::dropIfExists('dm_salinan_bukus');
    }
};
