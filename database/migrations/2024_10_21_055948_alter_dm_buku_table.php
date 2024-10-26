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
        Schema::table('dm_buku', function (Blueprint $table) {
            $table->tinyInteger('dbuku_flag')->default(0)->after('dbuku_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('dm_buku', function (Blueprint $table) {
            $table->dropColumn('id_dmapel');
            $table->dropColumn('id_dkategori');
        });
    }
};
