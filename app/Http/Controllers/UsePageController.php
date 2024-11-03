<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\dm_buku;
use App\Models\Transaksi;

class UsePageController extends Controller
{
    public function berandaPage()
    {
   
        $datadepan = DB::table('trks_transaksi')
        ->select(
            'dm_buku.id_dbuku',
            'dm_buku.dbuku_judul',
            'dm_buku.dbuku_cover',
            'dm_penulis.dpenulis_nama_penulis',
            DB::raw('COUNT(trks_transaksi.id_dbuku) as datadepan')
        )
        ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
        ->join('dm_penulis', 'dm_buku.id_dpenulis', '=', 'dm_penulis.id_dpenulis')
        ->groupBy('dm_buku.id_dbuku', 'dm_buku.dbuku_judul', 'dm_buku.dbuku_cover', 'dm_penulis.dpenulis_nama_penulis')
        ->orderByDesc('datadepan')
        ->take(6)
        ->get();
        return view('welcome', compact('datadepan'));
    }
    
    public function showByCategory($kategori)
{
    if ($kategori === 'penulis_asing') {
        // Filter penulis yang bukan dari Indonesia
        $penulis = DmPenulis::where('dpenulis_kewarganegaraan', '!=', 'Indonesia')
            ->withCount(['books as borrow_count' => function($query) {
                $query->select(DB::raw("SUM(peminjaman_count)"));
            }])
            ->orderBy('borrow_count', 'desc')
            ->take(10)
            ->get();
    } elseif ($kategori === 'penulis_lokal') {
        // Filter penulis dari Indonesia
        $penulis = DmPenulis::where('dpenulis_kewarganegaraan', 'Indonesia')
            ->withCount(['books as borrow_count' => function($query) {
                $query->select(DB::raw("SUM(peminjaman_count)"));
            }])
            ->orderBy('borrow_count', 'desc')
            ->take(10)
            ->get();
    } elseif ($kategori === 'penulis_terbaru') {
        // Filter penulis terbaru berdasarkan tanggal lahir atau data tambahan
        $penulis = DmPenulis::orderBy('dpenulis_tgl_lahir', 'desc')
            ->take(10)
            ->get();
    }

    return response()->json($penulis);
}
    
}
