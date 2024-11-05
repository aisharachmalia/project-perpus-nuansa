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

        $pnb = \DB::select(
            "SELECT * FROM dm_penerbits
                        WHERE dm_penerbits.deleted_at IS NULL;
"
        );
        return view('welcome', compact('datadepan', 'buku', 'pnb'));
    }

    public function pageBukuByPenerbit(Request $request, $penerbit = null)
    {
        $penerbit = \Crypt::decryptString($penerbit);
        $pnb = \DB::select("SELECT * FROM dm_penerbits
                        WHERE dm_penerbits.deleted_at IS NULL AND dm_penerbits.id_dpenerbit = $penerbit;
        ");

        // Dekripsi jika parameter diterima
        if ($penerbit) {
            $buku = dm_buku::where('id_dpenerbit', $penerbit)->get();
        } else {
            $buku = dm_buku::all();
        }

        return view('user.buku_by_penerbit', compact('buku', 'pnb'));
    }

    public function PagePenulsFav()
    {
        $datadepan = DB::table('trks_transaksi')
            ->select(
                'dm_penulis.id_dpenulis',
                'dm_penulis.dpenulis_nama_penulis',
                DB::raw('SUM(trks_transaksi.id_dbuku) as total_peminjaman')
            )
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_penulis', 'dm_buku.id_dpenulis', '=', 'dm_penulis.id_dpenulis')
            ->groupBy('dm_penulis.id_dpenulis', 'dm_penulis.dpenulis_nama_penulis')
            ->orderByDesc('total_peminjaman')
            ->take(5)
            ->get();

        // Initialize an array to hold books for each author
        $bukuByPenulis = [];

        // For each author, get their books
        foreach ($datadepan as $author) {
            $bukuByPenulis[$author->id_dpenulis] = DB::table('dm_buku')
                ->select(
                    'dm_buku.id_dbuku',
                    'dm_buku.dbuku_judul',
                    'dm_buku.dbuku_cover',
                    'dm_penulis.dpenulis_nama_penulis',
                    DB::raw('COUNT(trks_transaksi.id_dbuku) as total_peminjaman')
                )
                ->join('dm_penulis', 'dm_buku.id_dpenulis', '=', 'dm_penulis.id_dpenulis')
                ->leftJoin('trks_transaksi', 'dm_buku.id_dbuku', '=', 'trks_transaksi.id_dbuku')
                ->where('dm_penulis.id_dpenulis', $author->id_dpenulis) // Filter by author
                ->groupBy('dm_buku.id_dbuku', 'dm_buku.dbuku_judul', 'dm_buku.dbuku_cover', 'dm_penulis.dpenulis_nama_penulis')
                ->orderByDesc('total_peminjaman')
                ->get();
        }
        return view('user.halaman_penulis_fav', compact('datadepan', 'bukuByPenulis'));
    }

    public function PagePenulisLokal()
    {
        $pnls = DB::table('dm_penulis')
            ->select(
                'dm_penulis.id_dpenulis',
                'dm_penulis.dpenulis_nama_penulis',
            )
            ->where('dm_penulis.deleted_at', null)
            ->where('dm_penulis.dpenulis_kewarganegaraan', 'Indonesia')
            ->take(5)
            ->get();

        $bukuByPenulis = [];

        // Loop through each author and get their respective books.
        foreach ($pnls as $author) {
            $bukuByPenulis[$author->id_dpenulis] = DB::table('dm_buku')
                ->select(
                    'dm_buku.id_dbuku',
                    'dm_buku.dbuku_judul',
                    'dm_buku.dbuku_cover',
                    'dm_penulis.dpenulis_nama_penulis'
                )
                ->join('dm_penulis', 'dm_buku.id_dpenulis', '=', 'dm_penulis.id_dpenulis')
                ->whereNull('dm_penulis.deleted_at')
                ->where('dm_penulis.dpenulis_kewarganegaraan', 'Indonesia')
                ->where('dm_buku.id_dpenulis', $author->id_dpenulis)
                ->get();
        }

        return view('user.halaman_penulis_lokal', compact('pnls', 'bukuByPenulis'));
    }
    public function pageBuku(Request $request)
    {
        $query = $request->input('query');
    
        if ($query) {
            // Search books with titles that match the query
            $buku = DB::table('dm_buku')
                ->where('dbuku_judul', 'like', '%' . $query . '%')
                ->get();
        } else {
            // If no query, retrieve all books
            $buku = dm_buku::all();
        }
    
        return view('user.halaman_buku', compact('buku', 'query'));
    }
    

}