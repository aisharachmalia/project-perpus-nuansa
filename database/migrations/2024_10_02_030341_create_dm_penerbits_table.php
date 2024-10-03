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
        Schema::create('dm_penerbits', function (Blueprint $table) {
            $table->increments('id_dpenerbit');
            $table->string('dpenerbit_nama_penerbit')->unique();
            $table->text('dpenerbit_alamat');
            $table->string('dpenerbit_no_kontak')->unique();
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
        Schema::dropIfExists('dm_penerbits');
    }
};
