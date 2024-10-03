<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dm_kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        dm_kelas::create([
        'id_dkelas' => '1',
        'dkelas_nama_kelas' => 'X RPL 1',
        'dkelas_tingkat' => 'X',
        'dkelas_jurusan' => 'RPL'
    
    ]);

         dm_kelas::create([
         'id_dkelas' => '2',
         'dkelas_nama_kelas' => 'X RPL 2',
         'dkelas_tingkat' => 'X',
         'dkelas_jurusan' => 'RPL',
        
    ]);

         dm_kelas::create([
         'id_dkelas' => '3',
         'dkelas_nama_kelas' => 'X RPL 3',
         'dkelas_tingkat' => 'X',
         'dkelas_jurusan' => 'RPL',
        ]);

        dm_kelas::create([
         'id_dkelas' => '4',
         'dkelas_nama_kelas' => 'X TKRO 1',
         'dkelas_tingkat' => 'X',
         'dkelas_jurusan' => 'TKRO',
        
        ]);

        dm_kelas::create([
        'id_dkelas' => '5',
        'dkelas_nama_kelas' => 'X TKRO 2',
        'dkelas_tingkat' => 'X',
        'dkelas_jurusan' => 'TKRO',
    
        ]);

        dm_kelas::create([
        'id_dkelas' => '6',
        'dkelas_nama_kelas' => 'X TBSM 1',
        'dkelas_tingkat' => 'X',
        'dkelas_jurusan' => 'TBSM',

    ]);

            dm_kelas::create([
            'id_dkelas' => '7',
            'dkelas_nama_kelas' => 'XI RPL 1',
            'dkelas_tingkat' => 'XI',
            'dkelas_jurusan' => 'RPL',

        ]);

        dm_kelas::create([
            'id_dkelas' => '8',
            'dkelas_nama_kelas' => 'XI RPL 2',
            'dkelas_tingkat' => 'XI',
            'dkelas_jurusan' => 'RPL',

        ]);

        dm_kelas::create([
        'id_dkelas' => '9',
        'dkelas_nama_kelas' => 'XI RPL 3',
        'dkelas_tingkat' => 'XI',
        'dkelas_jurusan' => 'RPL',

    ]);

        dm_kelas::create([
        'id_dkelas' => '10',
        'dkelas_nama_kelas' => 'XI TKRO 1',
        'dkelas_tingkat' => 'XI',
        'dkelas_jurusan' => 'TKRO',

    ]);

        dm_kelas::create([
        'id_dkelas' => '11',
        'dkelas_nama_kelas' => 'XI TBSM 1',
        'dkelas_tingkat' => 'XI',
        'dkelas_jurusan' => 'TBSM',

    ]);

        dm_kelas::create([
        'id_dkelas' => '12',
        'dkelas_nama_kelas' => 'XI TBSM 2',
        'dkelas_tingkat' => 'XI',
        'dkelas_jurusan' => 'TBSM',

    ]);

        dm_kelas::create([
        'id_dkelas' => '13',
        'dkelas_nama_kelas' => 'XII RPL 1',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'RPL',

    ]);

        dm_kelas::create([
        'id_dkelas' => '14',
        'dkelas_nama_kelas' => 'XII RPL 2',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'RPL',

    ]);

        dm_kelas::create([
        'id_dkelas' => '15',
        'dkelas_nama_kelas' => 'XII RPL 3',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'RPL',

    ]);

        dm_kelas::create([
        'id_dkelas' => '16',
        'dkelas_nama_kelas' => 'XII RPL 4',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'RPL',

    ]);

        dm_kelas::create([
        'id_dkelas' => '17',
        'dkelas_nama_kelas' => 'XII TKRO 1',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'TKRO',

    ]);

    dm_kelas::create([
        'id_dkelas' => '18',
        'dkelas_nama_kelas' => 'XII TKRO 2',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'TKRO',

    ]);

        dm_kelas::create([
        'id_dkelas' => '19',
        'dkelas_nama_kelas' => 'XII TBSM 1',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'TBSM',

    ]);

        dm_kelas::create([
        'id_dkelas' => '20',
        'dkelas_nama_kelas' => 'XII TBSM 2',
        'dkelas_tingkat' => 'XII',
        'dkelas_jurusan' => 'TBSM',

    ]);




    }
}
