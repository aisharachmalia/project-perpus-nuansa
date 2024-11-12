<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BukuExport;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function pageLaporan()
    {
        return view('laporan.index');
    }


    public function tableTrks(Request $request)
    {
        $filt = '';

        if ($request->get('status') == '1' || $request->get('status') == '2' || $request->get('status') == '3') {
            $filt .= "AND trks_transaksi.trks_status = '" . $request->get('status') . "' ";
        }

        if ($request->get('buku')) {
            // Decrypt the book ID if it's encrypted
            $buku_id = decrypt($request->get('buku'));
            $filt .= "AND trks_transaksi.id_dbuku LIKE '%" . $buku_id . "%'";
        }

        if ($request->get('siswa')) {
            // Decrypt the student ID if it's encrypted
            $siswa_id = decrypt($request->get('siswa'));
            $filt .= "AND trks_transaksi.id_usr LIKE '%" . $siswa_id . "%'";
        }

        if ($request->get('tanggal_awal') && $request->get('tanggal_akhir')) {
            $filt .= "AND DATE_FORMAT(trks_transaksi.trks_tgl_peminjaman, '%Y-%m-%d') BETWEEN '" . $request->get('tanggal_awal') . "' AND '" . $request->get('tanggal_akhir') . "'";
        }

        $trks = \DB::select(
            "SELECT trks_transaksi.*,
                            dm_buku.dbuku_judul,
                            users.usr_nama,
                            trks_denda.jumlah
                    FROM trks_transaksi
                    LEFT JOIN dm_buku ON trks_transaksi.id_dbuku = dm_buku.id_dbuku
                    LEFT JOIN users ON trks_transaksi.id_usr = users.id_usr
                    LEFT JOIN trks_denda ON trks_transaksi.id_trks = trks_denda.id_trks
                    WHERE trks_transaksi.deleted_at IS NULL $filt"
        );


        if ($request->ajax()) {
            return DataTables::of($trks)
                ->addIndexColumn()
                ->editColumn('trks_tgl_peminjaman', function ($trks) {
                    return Carbon::parse($trks->trks_tgl_peminjaman)->format('d-m-Y H:i');
                })
                ->editColumn('trks_tgl_jatuh_tempo', function ($trks) {
                    return Carbon::parse($trks->trks_tgl_jatuh_tempo)->format('d-m-Y');
                })
                ->editColumn('trks_tgl_pengembalian', function ($trks) {
                    return $trks->trks_tgl_pengembalian ? Carbon::parse($trks->trks_tgl_pengembalian)->format('d-m-Y H:i') : '-';
                })
                ->editColumn('jumlah', function ($trks) {
                    return 'Rp. ' . ($trks->jumlah !== null ? number_format($trks->jumlah, 0, ',', '.') : '0');
                })
                ->make(true);
        }

    }

    public function linkExportLaporan(Request $request)
    {
        try {
            $link = route('export_laporan');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportLaporan(Request $request)
    {
        try {
            return (new LaporanExport)->dataExport($request->all())->download('Rekap Laoran Transaksi.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function linkPrintoutLaporan(Request $request)
    {
        try {
            $link = route('printout_laporan');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutLaporan(Request $request)
    {
        try {
            $filename = 'Laporan Transaksi.pdf';

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

            $html = \View::make('pdf.pdf_laporan_transaksi', [
                'title' => 'Data Laporan Transaksi',
                'trks' => $trks
            ])->render();

            TCPDF::setPrintHeader(false);
            TCPDF::setPrintFooter(false);
            TCPDF::SetPageOrientation('L');
            TCPDF::SetMargins(4, 3, 3, true);

            $code = 'https://tcpdf.org/examples/example_050/';

            TCPDF::AddPage();
            TCPDF::write2DBarcode($code, 'QRCODE,Q', 240, 150, 44, 35, false, 'P');
            TCPDF::writeHTML($html, true, false, true, false, '');

            return TCPDF::Output($filename, 'I');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
