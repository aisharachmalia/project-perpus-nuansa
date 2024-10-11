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
                                            dm_mapels.dmapel_nama_mapel, 
                                            dm_penulis.dpenulis_nama_penulis, 
                                            dm_penerbits.dpenerbit_nama_penerbit, 
                                            dm_kategoris.dkategori_nama_kategori 
                                    FROM dm_buku 
                                    JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                                    JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                                    JOIN dm_kategoris ON dm_buku.id_dkategori = dm_kategoris.id_dkategori 
                                    JOIN dm_mapels ON dm_buku.id_dmapel = dm_mapels.id_mapel 
                                    WHERE dm_buku.deleted_at IS NULL;
");

        return view('export.exc_laporan', compact('buku'));
    }
}
