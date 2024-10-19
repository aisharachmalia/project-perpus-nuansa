<?php

namespace App\Http\Controllers;

use App\Models\Dm_buku;
use App\Models\Dm_siswa;
use App\Models\dm_kategori;
use App\Models\Transaksi;
use App\Models\Trks_denda;
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
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query peminjaman terbanyak
        $peminjaman_terbanyak = DB::table('trks_transaksi')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->select('dm_siswas.dsiswa_nama', DB::raw('COUNT(trks_transaksi.id_dbuku) as total_bacaan'))
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->groupBy('dm_siswas.dsiswa_nama')
            ->orderBy('total_bacaan', 'desc')
            ->take(5)
            ->get();

        // Query buku yang paling banyak dipinjam
        $bukuTerbanyakDipinjam = DB::table('trks_transaksi')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->select('dm_buku.dbuku_judul', DB::raw('COUNT(trks_transaksi.id_dbuku) as total_peminjaman'))
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->groupBy('dm_buku.id_dbuku', 'dm_buku.dbuku_judul')
            ->orderBy('total_peminjaman', 'desc')
            ->take(5)
            ->get();

        // Statistik peminjaman bulanan
        $statistikPeminjaman = DB::table('trks_transaksi')
        ->select(DB::raw('MONTH(trks_tgl_peminjaman) as bulan'), DB::raw('COUNT(*) as total'))
        ->when($bulan, function ($query) use ($bulan) {
            return $query->whereMonth('trks_tgl_peminjaman', $bulan);
        })
        ->when($tahun, function ($query) use ($tahun) {
            return $query->whereYear('trks_tgl_peminjaman', $tahun);
        })
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
    
        // Query kategori yang paling banyak dipinjam
        $kategoriData = DB::table('trks_transaksi')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_kategoris', 'dm_buku.id_dkategori', '=', 'dm_kategoris.id_dkategori')
            ->select('dm_kategoris.dkategori_nama_kategori', DB::raw('COUNT(trks_transaksi.id_dbuku) as total_peminjaman'))
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->groupBy('dm_kategoris.dkategori_nama_kategori')
            ->get();

        // Format data untuk Highcharts
        $chartData = [];
        foreach ($kategoriData as $kategori) {
            $chartData[] = [
                'name' => $kategori->dkategori_nama_kategori,
                'y' => $kategori->total_peminjaman,
            ];
        }

        // Mempersiapkan data untuk Highcharts
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = $statistikPeminjaman->where('bulan', $i)->first();
            $data[] = $total ? $total->total : 0; // Mengisi dengan 0 jika tidak ada peminjaman
        }

        // Hitung total siswa, buku, peminjaman, dan denda
        $totalSiswa = Dm_siswa::whereNull('deleted_at')->count();

        $totalBuku = DB::table('dm_buku')->whereNull('deleted_at')
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->sum('dbuku_jml_total');

        $totalPeminjaman = DB::table('trks_transaksi')->whereNull('deleted_at')
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->count();

        $totalDenda = DB::table('trks_denda')->whereNull('deleted_at')
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tdenda_tgl_bayar', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tdenda_tgl_bayar', $tahun);
            })
            ->sum('tdenda_jumlah'); // Pastikan kolom 'tdenda_jumlah' digunakan untuk menyimpan nilai denda

        // Kirim hasil ke view
        return view('home', compact('totalSiswa', 'totalBuku', 'totalPeminjaman', 'totalDenda', 'peminjaman_terbanyak', 'statistikPeminjaman', 'data', 'bukuTerbanyakDipinjam', 'chartData', 'bulan', 'tahun'));

    }
}
