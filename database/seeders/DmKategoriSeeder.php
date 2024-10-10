<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DmKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dm_kategoris')->insert([
            [
                'dkategori_nama_kategori' => 'Komik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Novel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Kamus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Dongeng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Buku Ilmiah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Ensiklopedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Atlas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'dkategori_nama_kategori' => 'Agatha Christie',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'dkategori_nama_kategori' => 'Leo Tolstoy',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'dkategori_nama_kategori' => 'Charles Dickens',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'dkategori_nama_kategori' => 'Gabriel García Márquez',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
