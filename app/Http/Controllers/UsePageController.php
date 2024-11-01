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

        $buku = dm_buku::all();
        return view('welcome', compact('datadepan','buku'));
    }
    
    
}
