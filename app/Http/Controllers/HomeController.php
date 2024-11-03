<?php

namespace App\Http\Controllers;

use App\Models\Dm_siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Ambil input bulan dan tahun dari request
     


    return view('home');
    }
    public function totalDataDashboard(Request $request)
    {
        $tanggalawal = $request->input('tanggal_awal');
        $tanggalakhir = $request->input('tanggal_akhir');

        // Kondisi untuk filter tanggal
        $kond = "";
        if ($tanggalawal && $tanggalakhir) {
            $kond = "AND DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '$tanggalawal' AND '$tanggalakhir'";
        }

        // Kondisi untuk filter tanggal trks_transaksi
        $kond1 = "";
        if ($tanggalawal && $tanggalakhir) {
            $kond1 = "AND DATE_FORMAT(trks_transaksi.created_at, '%Y-%m-%d') BETWEEN '$tanggalawal' AND '$tanggalakhir'";
        }
        $kond2 = "";
        if ($tanggalawal && $tanggalakhir) {
            $kond2 = "AND DATE_FORMAT(trks_transaksi.created_at, '%Y-%m-%d') BETWEEN '$tanggalawal' AND '$tanggalakhir'";
        }

        // Total data
        $data['total_buku'] = \DB::select("SELECT SUM(dbuku_jml_total) as total_buku FROM dm_buku WHERE deleted_at IS NULL $kond")[0]->total_buku;

        $data['total_peminjaman'] = \DB::select("SELECT COUNT(*) as total_peminjaman FROM trks_transaksi WHERE deleted_at IS NULL $kond")[0]->total_peminjaman;

        $data['total_denda'] = \DB::select("SELECT SUM(jumlah) as total_denda FROM pembayarans WHERE deleted_at IS NULL $kond")[0]->total_denda;

        $data['total_pelanggaran'] = \DB::select("SELECT COUNT(*) as total_pelanggaran FROM trks_denda WHERE deleted_at IS NULL $kond")[0]->total_pelanggaran;

        // Ambil data peminjaman terbanyak
        $peminjaman_terbanyak = \DB::select("SELECT users.usr_nama, COUNT(trks_transaksi.id_dbuku) as total_peminjaman FROM trks_transaksi JOIN users ON trks_transaksi.id_usr = users.id_usr WHERE trks_transaksi.deleted_at IS NULL $kond1 GROUP BY users.usr_nama ORDER BY total_peminjaman DESC LIMIT 5");
        $html_peminjaman_terbanyak = '';
        if (count($peminjaman_terbanyak) > 0) {
            foreach ($peminjaman_terbanyak as $key => $value) {
                $no = $key + 1;
                $html_peminjaman_terbanyak .= '<tr>
                                                <td>' . $no . '</td>
                                                <td>' . $value->usr_nama . '</td>
                                                <td>' . $value->total_peminjaman . '</td>
                                            </tr>';
            }
        } else {
            $html_peminjaman_terbanyak .= '<tr>
                                            <td colspan="3">Data Peminjam Tidak Tersedia</td>
                                        </tr>';
        }
        $data['peminjaman_terbanyak'] = $html_peminjaman_terbanyak;

        // Buku terbanyak dipinjam
        $buku_terbanyak_dipinjam = \DB::select("SELECT dm_buku.dbuku_judul, dm_buku.dbuku_cover, dm_penulis.dpenulis_nama_penulis, COUNT(trks_transaksi.id_dbuku) as total_peminjaman FROM trks_transaksi JOIN dm_buku ON trks_transaksi.id_dbuku = dm_buku.id_dbuku JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis WHERE trks_transaksi.deleted_at IS NULL $kond1 GROUP BY dm_buku.dbuku_judul, dm_buku.dbuku_cover, dm_penulis.dpenulis_nama_penulis ORDER BY total_peminjaman DESC LIMIT 5");

        // Generate HTML untuk buku terbanyak dipinjam
        // Generate HTML untuk buku terbanyak dipinjam
        $html_buku_terbanyak_dipinjam = '';
        if (count($buku_terbanyak_dipinjam) > 0) {
            foreach ($buku_terbanyak_dipinjam as $key => $value) {
                $no = $key + 1;
                // Pastikan path menuju assets folder
                $coverImagePath = asset('storage/cover/' . $value->dbuku_cover);
                $coverImage = $value->dbuku_cover ? "<img src='{$coverImagePath}' alt='{$value->dbuku_judul}' style='width: 50px; height: auto;'>" : 'Cover Tidak Tersedia';
                $html_buku_terbanyak_dipinjam .= "
                                    <tr>
                                        <td>{$coverImage}</td>
                                        <td>{$value->dbuku_judul}</td>
                                        <td>{$value->dpenulis_nama_penulis}</td>
                                        <td>{$value->total_peminjaman}</td>
                                    </tr>";
            }
        } else {
            $html_buku_terbanyak_dipinjam .= "
                                <tr>
                                    <td colspan='4'>Data Peminjaman Tidak Tersedia</td>
                                </tr>";
        }
        $data['buku_terbanyak_dipinjam'] = $html_buku_terbanyak_dipinjam;


        $statistik_peminjaman = \DB::select(
            "SELECT MONTH(trks_tgl_peminjaman) AS bulan, COUNT(*) AS total
                        FROM trks_transaksi
                        WHERE trks_tgl_peminjaman BETWEEN ? AND ?
                        GROUP BY bulan
                        ORDER BY bulan",[$tanggalawal, $tanggalakhir]
        );

        // Format data for Highcharts
        $data['statistik_peminjaman'] = array_fill(0, 12, 0); // Default array dengan 12 bulan
        foreach ($statistik_peminjaman as $item) {
            $data['statistik_peminjaman'][$item->bulan - 1] = $item->total; // Menyesuaikan index array dengan bulan
        }
        return response()->json($data);
    }
}
