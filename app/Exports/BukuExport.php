<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Crypt;
class BukuExport implements FromView
{
    use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $buku = \DB::select("SELECT dm_buku.*, 
                                            dm_penulis.dpenulis_nama_penulis, 
                                            dm_penerbits.dpenerbit_nama_penerbit
                                    FROM dm_buku 
                                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                                    WHERE dm_buku.deleted_at IS NULL;
");

        return view('export.exc_buku', compact('buku'));
    }
}
