<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\dm_salinan_buku;

class BukuSalinanExport implements FromView
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        // Query the database for salinan buku records based on the ID
        $salinan = dm_salinan_buku::where('id_dbuku', $this->id)->whereNull('deleted_at')->get();

        $bk = \DB::select(
            "SELECT dm_buku.*,                                         
                            dm_penulis.dpenulis_nama_penulis, 
                            dm_penerbits.dpenerbit_nama_penerbit
                    FROM dm_buku 
                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                    WHERE dm_buku.id_dbuku = $this->id; 
        "
        );

        return view('export.exc_salinan_buku', compact('salinan', 'bk'));
    }
}
