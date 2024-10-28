<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Crypt;

class LaporanExport implements FromView
{
    use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $trks = \DB::select(
            "SELECT trks_transaksi.*,
                            dm_buku.dbuku_judul,
                            users.usr_nama,
                            trks_denda.jumlah
                    FROM trks_transaksi
                    LEFT JOIN dm_buku ON trks_transaksi.id_dbuku = dm_buku.id_dbuku
                    LEFT JOIN users ON trks_transaksi.id_usr = users.id_usr
                    LEFT JOIN trks_denda ON trks_transaksi.id_trks = trks_denda.id_trks
                    WHERE trks_transaksi.deleted_at IS NULL"
        );

        return view('export.exc_laporan', compact('trks'));
    }
}
