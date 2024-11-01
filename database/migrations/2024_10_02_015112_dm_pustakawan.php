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
        Schema::create('dm_pustakawan', function (Blueprint $table) {
            $table->increments('id_dpustakawan');
            $table->string('dpustakawan_nama');
            $table->string('dpustakawan_email')->unique();
            $table->string('dpustakawan_no_telp')->unique();
            $table->text('dpustakawan_alamat')->nullable();
            $table->tinyInteger('dpustakawan_status')->default(1);
            $table->tinyInteger('dpustakawan_flag')->default(0);
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
        Schema::dropIfExists('dm_pustakawan');
    }
};
