<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DmBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dm_buku')->insert([
            [
                'dbuku_cover' => 'cover1.jpg',
                'dbuku_judul' => 'Laravel in Action',
                'id_dpenulis' => 1,
                'id_dpenerbit' => 1,
                'dbuku_thn_terbit' => '2022',
                'dbuku_isbn' => '9781234567897',
                'dbuku_jml_tersedia' => 0,
                'dbuku_jml_total' => 0,
                'dbuku_lokasi_rak' => 'A1',
                'dbuku_edisi' => 1,
                'dbuku_bahasa' => 'Indonesian',
                'dbuku_file' => 'laravel.pdf',
                'dbuku_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dbuku_cover' => 'cover2.jpg',
                'dbuku_judul' => 'Mastering PHP',
                'id_dpenulis' => 2,
                'id_dpenerbit' => 2,
                'dbuku_thn_terbit' => '2020',
                'dbuku_isbn' => '9789876543210',
                'dbuku_jml_tersedia' => 0,
                'dbuku_jml_total' => 0,
                'dbuku_lokasi_rak' => 'B2',
                'dbuku_edisi' => 3,
                'dbuku_bahasa' => 'English',
                'dbuku_file' => 'php.pdf',
                'dbuku_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dbuku_cover' => 'cover3.jpg',
                'dbuku_judul' => 'JavaScript: The Good Parts',
                'id_dpenulis' => 3,
                'id_dpenerbit' => 3,
                'dbuku_thn_terbit' => '2018',
                'dbuku_isbn' => '9782345678901',
                'dbuku_jml_tersedia' => 0,
                'dbuku_jml_total' => 0,
                'dbuku_lokasi_rak' => 'C3',
                'dbuku_edisi' => 2,
                'dbuku_bahasa' => 'English',
                'dbuku_file' => 'js.pdf',
                'dbuku_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dbuku_cover' => 'cover4.jpg',
                'dbuku_judul' => 'Python for Data Science',
                'id_dpenulis' => 4,
                'id_dpenerbit' => 4,
                'dbuku_thn_terbit' => '2019',
                'dbuku_isbn' => '9783456789012',
                'dbuku_jml_tersedia' => 0,
                'dbuku_jml_total' => 0,
                'dbuku_lokasi_rak' => 'D4',
                'dbuku_edisi' => 1,
                'dbuku_bahasa' => 'Indonesian',
                'dbuku_file' => 'python.pdf',
                'dbuku_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dbuku_cover' => 'cover5.jpg',
                'dbuku_judul' => 'React Native in Action',
                'id_dpenulis' => 5,
                'id_dpenerbit' => 5,
                'dbuku_thn_terbit' => '2021',
                'dbuku_isbn' => '9784567890123',
                'dbuku_jml_tersedia' => 0,
                'dbuku_jml_total' => 0,
                'dbuku_lokasi_rak' => 'E5',
                'dbuku_edisi' => 2,
                'dbuku_bahasa' => 'English',
                'dbuku_file' => 'react.pdf',
                'dbuku_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
