<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Crypt;

use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $siswa = \DB::select("SELECT ds.*,dk.dkelas_nama_kelas FROM dm_siswas as ds JOIN dm_kelas as dk ON dk.id_dkelas = ds.id_dkelas");
        return view('export.exc_siswa', compact('siswa'));
    }
}
