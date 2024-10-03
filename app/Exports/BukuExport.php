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
        $buku = \DB::select("SELECT db.*,dp.dpenulis_nama_penulis 
                            FROM dm_buku as db
                            JOIN dm_penulis as dp ON dp.id_dpenulis = db.id_dpenulis");

        return view('export.exc_buku',compact('buku'));
    }
}
