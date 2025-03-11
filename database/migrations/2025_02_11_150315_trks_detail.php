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
        $table->increments('id_trks_detail');
            $table->integer('id_dbuku');
            $table->dateTime('trks_tgl_pengembalian')->nullable();
            $table->double('denda_per_buku')->nullable();
            $table->text('trks_keterangan')->nullable();
            $table->tinyInteger('trks_status')->default(0);
            $table->timestamps();
            $table->softDeletes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
