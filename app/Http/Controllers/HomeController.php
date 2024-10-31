<?php

namespace App\Http\Controllers;

use App\Models\Dm_buku;
use App\Models\Dm_siswa;
use App\Models\Dm_penulis;
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
        // Ambil input bulan dan tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query untuk peminjaman terbanyak
        // Query for most frequent borrowers
        $peminjaman_terbanyak = DB::table('trks_transaksi')
            ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
            ->select('users.usr_nama', DB::raw('COUNT(trks_transaksi.id_dbuku) as total_bacaan'))
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->groupBy('users.usr_nama')
            ->orderBy('total_bacaan', 'desc')
            ->take(5)
            ->get();


        // Query buku yang paling banyak dipinjam
        $bukuTerbanyakDipinjam = DB::table('trks_transaksi')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_penulis', 'dm_buku.id_dpenulis', '=', 'dm_penulis.id_dpenulis') // Join dengan tabel penulis
            ->select(
                'dm_buku.dbuku_judul',
                'dm_buku.dbuku_cover',
                'dm_penulis.dpenulis_nama_penulis',
                DB::raw('COUNT(trks_transaksi.id_dbuku) as total_peminjaman')
            )
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('trks_tgl_peminjaman', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('trks_tgl_peminjaman', $tahun);
            })
            ->groupBy('dm_buku.id_dbuku', 'dm_buku.dbuku_judul', 'dm_buku.dbuku_cover', 'dm_penulis.dpenulis_nama_penulis')
            ->orderBy('total_peminjaman', 'desc')
            ->take(5)
            ->get();

        // Query statistik peminjaman bulanan
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

        // Query kategori buku yang paling banyak dipinjam
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

        // Format data kategori untuk Highcharts
        $chartData = [];
        foreach ($kategoriData as $kategori) {
            $chartData[] = [
                'name' => $kategori->dkategori_nama_kategori,
                'y' => $kategori->total_peminjaman,
            ];
        }

        // Format data statistik peminjaman bulanan untuk Highcharts
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = $statistikPeminjaman->where('bulan', $i)->first();
            $data[] = $total ? $total->total : 0; // Isi dengan 0 jika tidak ada peminjaman
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

        $totalDenda = DB::table('pembayarans')
            ->whereNull('deleted_at')
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tgl_pembayaran', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tgl_pembayaran', $tahun);
            })
            ->sum('jumlah');


        // Kirim hasil ke view
        return view('home', compact(
            'totalSiswa',
            'totalBuku',
            'totalPeminjaman',
            'totalDenda',
            'peminjaman_terbanyak',
            'statistikPeminjaman',
            'data',
            'bukuTerbanyakDipinjam',
            'chartData',
            'bulan',
            'tahun'
        ));
    }
}
