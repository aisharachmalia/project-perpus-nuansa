<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DmMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dm_mapels')->insert([
            ['id_mapel' => 1, 'dmapel_nama_mapel' => 'Matematika', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 2, 'dmapel_nama_mapel' => 'Bahasa Indonesia', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 3, 'dmapel_nama_mapel' => 'IPA', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 4, 'dmapel_nama_mapel' => 'IPS', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 5, 'dmapel_nama_mapel' => 'Bahasa Inggris', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 6, 'dmapel_nama_mapel' => 'BK', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 7, 'dmapel_nama_mapel' => 'PPKN', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 8, 'dmapel_nama_mapel' => 'PJOK', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 9, 'dmapel_nama_mapel' => 'RPL', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 10, 'dmapel_nama_mapel' => 'TBSM', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 11, 'dmapel_nama_mapel' => 'TKRO', 'created_at' => now(), 'updated_at' => now()],
            ['id_mapel' => 12, 'dmapel_nama_mapel' => 'Bahasa Jepang', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

