<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dm_siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dm_siswa::create([
            'dsiswa_nama' => 'kiara',
            'dsiswa_nis' => 'KIA12345',
            'dsiswa_email' => 'kiara@gmail.com',
            'dsiswa_no_telp' => '0945845848',
            'dsiswa_alamat' => 'rancamanyar',
            'dsiswa_sts' => '1',
            'id_dkelas' => '3',
        ]);

    }
}
