<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DMPustakawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dm_pustakawan')->insert([
            [
                'dpustakawan_nama' => 'Ahmad Syarif',
                'dpustakawan_email' => 'ahmad.syarif@example.com',
                'dpustakawan_no_telp' => '081234567890',
                'dpustakawan_alamat' => 'Jl. Merdeka No. 10',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Budi Santoso',
                'dpustakawan_email' => 'budi.santoso@example.com',
                'dpustakawan_no_telp' => '081987654321',
                'dpustakawan_alamat' => 'Jl. Sudirman No. 5',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Citra Dewi',
                'dpustakawan_email' => 'citra.dewi@example.com',
                'dpustakawan_no_telp' => '0821122334455',
                'dpustakawan_alamat' => 'Jl. Thamrin No. 22',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Deni Setiawan',
                'dpustakawan_email' => 'deni.setiawan@example.com',
                'dpustakawan_no_telp' => '08335566778899',
                'dpustakawan_alamat' => 'Jl. Pahlawan No. 15',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Eka Putri',
                'dpustakawan_email' => 'eka.putri@example.com',
                'dpustakawan_no_telp' => '08446677889900',
                'dpustakawan_alamat' => 'Jl. Diponegoro No. 18',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Fajar Hidayat',
                'dpustakawan_email' => 'fajar.hidayat@example.com',
                'dpustakawan_no_telp' => '08554455667788',
                'dpustakawan_alamat' => 'Jl. Gajah Mada No. 30',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'dpustakawan_nama' => 'Gita Ananda',
                'dpustakawan_email' => 'gita.ananda@example.com',
                'dpustakawan_no_telp' => '08667788990011',
                'dpustakawan_alamat' => 'Jl. Kartini No. 50',
                'dpustakawan_status' => '1',
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
        ]);
    }
}
