<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DmGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dm_gurus')->insert([
            [
                'dguru_nama' => 'Ahmad Syarif',
                'dguru_nip' => '1234567890',
                'dguru_email' => 'ahmad.syarif@example.com',
                'dguru_no_telp' => '081234567890',
                'dguru_alamat' => 'Jl. Merdeka No. 10',
                'id_mapel' => 1,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Budi Santoso',
                'dguru_nip' => '0987654321',
                'dguru_email' => 'budi.santoso@example.com',
                'dguru_no_telp' => '081987654321',
                'dguru_alamat' => 'Jl. Sudirman No. 5',
                'id_mapel' => 2,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Citra Dewi',
                'dguru_nip' => '1122334455',
                'dguru_email' => 'citra.dewi@example.com',
                'dguru_no_telp' => '0821122334455',
                'dguru_alamat' => 'Jl. Thamrin No. 22',
                'id_mapel' => 3,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Deni Setiawan',
                'dguru_nip' => '5566778899',
                'dguru_email' => 'deni.setiawan@example.com',
                'dguru_no_telp' => '08335566778899',
                'dguru_alamat' => 'Jl. Pahlawan No. 15',
                'id_mapel' => 4,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Eka Putri',
                'dguru_nip' => '6677889900',
                'dguru_email' => 'eka.putri@example.com',
                'dguru_no_telp' => '08446677889900',
                'dguru_alamat' => 'Jl. Diponegoro No. 18',
                'id_mapel' => 5,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Fajar Hidayat',
                'dguru_nip' => '4455667788',
                'dguru_email' => 'fajar.hidayat@example.com',
                'dguru_no_telp' => '08554455667788',
                'dguru_alamat' => 'Jl. Gajah Mada No. 30',
                'id_mapel' => 1,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dguru_nama' => 'Gita Ananda',
                'dguru_nip' => '7788990011',
                'dguru_email' => 'gita.ananda@example.com',
                'dguru_no_telp' => '08667788990011',
                'dguru_alamat' => 'Jl. Kartini No. 50',
                'id_mapel' => 2,
                'dguru_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
