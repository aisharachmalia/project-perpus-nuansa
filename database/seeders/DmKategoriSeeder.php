<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ['dkategori_nama_kategori' => 'Buku Paket', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Fiksi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Non-Fiksi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Biografi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Sejarah', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Sains', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Teknologi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Agama', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Bisnis', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Kesehatan', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Kuliner', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Sastra', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Travel', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Hobi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Psikologi', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Pengembangan Diri', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Politik', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Seni', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Teknik', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
            ['dkategori_nama_kategori' => 'Bahasa', 'created_at' => Carbon::now('Asia/Jakarta'), 'updated_at' => Carbon::now('Asia/Jakarta'), 'deleted_at' => null],
        ]);
    }
}
