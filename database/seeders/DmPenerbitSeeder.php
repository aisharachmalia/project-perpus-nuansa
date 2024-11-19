<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DmPenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dm_penerbits')->insert([
            [
                'dpenerbit_nama_penerbit' => 'Gramedia Pustaka Utama',
                'dpenerbit_alamat' => 'Bandung',
                'dpenerbit_no_kontak' => '022-1234567',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Erlangga',
                'dpenerbit_alamat' => 'Jakarta',
                'dpenerbit_no_kontak' => '021-7654321',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Mizan',
                'dpenerbit_alamat' => 'Bandung',
                'dpenerbit_no_kontak' => '022-8765432',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Bentang Pustaka',
                'dpenerbit_alamat' => 'Yogyakarta',
                'dpenerbit_no_kontak' => '0274-567890',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'KPG (Kepustakaan Populer Gramedia)',
                'dpenerbit_alamat' => 'Jakarta',
                'dpenerbit_no_kontak' => '021-99887766',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Bhuana Ilmu Populer',
                'dpenerbit_alamat' => 'Jakarta',
                'dpenerbit_no_kontak' => '021-87654321',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Visi Media',
                'dpenerbit_alamat' => 'Bandung',
                'dpenerbit_no_kontak' => '022-12349876',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Pustaka Alvabet',
                'dpenerbit_alamat' => 'Jakarta',
                'dpenerbit_no_kontak' => '021-23456789',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Andi Publisher',
                'dpenerbit_alamat' => 'Yogyakarta',
                'dpenerbit_no_kontak' => '0274-5432198',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpenerbit_nama_penerbit' => 'Elex Media Komputindo',
                'dpenerbit_alamat' => 'Jakarta',
                'dpenerbit_no_kontak' => '021-67854321',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
        ]);
    }
}
