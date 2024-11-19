<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DmPenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dm_penulis')->insert([
            [
                'dpenulis_nama_penulis' => 'Pramoedya Ananta Toer',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1925-02-06',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Habiburrahman El Shirazy',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1976-09-30',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Dee Lestari',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1976-01-20',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Andrea Hirata',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1967-10-24',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Ahmad Fuadi',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1972-12-30',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Mira W.',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1951-09-13',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Asma Nadia',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1972-03-26',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Sapardi Djoko Damono',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1940-03-20',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Pidi Baiq',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1972-08-08',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenulis_nama_penulis' => 'Leila S. Chudori',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1962-12-12',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
        ]);
    }
}
