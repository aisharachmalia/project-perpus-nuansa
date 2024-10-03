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
                'dkategori_nama_kategori' => 'J.K. Rowling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'George Orwell',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Ernest Hemingway',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Jane Austen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Mark Twain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'F. Scott Fitzgerald',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Agatha Christie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Leo Tolstoy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Charles Dickens',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dkategori_nama_kategori' => 'Gabriel García Márquez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
