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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Tere Liye',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1979-05-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Ahmad Fuadi',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1972-12-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Dewi Lestari',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1976-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Andrea Hirata',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1967-10-24',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Mira W.',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1951-09-13',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Sapardi Djoko Damono',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1940-03-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Seno Gumira Ajidarma',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1958-06-19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Leila S. Chudori',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1962-12-12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dpenulis_nama_penulis' => 'Helvy Tiana Rosa',
                'dpenulis_kewarganegaraan' => 'Indonesia',
                'dpenulis_tgl_lahir' => '1970-04-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
