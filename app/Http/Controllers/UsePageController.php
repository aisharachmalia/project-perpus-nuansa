<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\dm_buku;
use App\Models\Transaksi;

class UsePageController extends Controller
{
    function berandaPage()
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

        foreach ($datadepan as $book) {
            if (\Storage::exists('public/cover/' . $book->dbuku_cover)) {
                // If the file exists, generate a URL to 'storage/cover/'
                $book->dbuku_cover = asset('storage/cover/' . $book->dbuku_cover);
            } else {
                // If the file does not exist, use the default image path
                $book->dbuku_cover = asset('assets/images/buku/default.jpg');
            }
        }
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




    public function pageBuku(Request $request)
    {
        $query = $request->input('query');
    
        if ($query) {
            // Cari buku berdasarkan judul yang cocok dengan query
            $buku = DB::table('dm_buku')
                ->where('dbuku_judul', 'like', '%' . $query . '%')
                ->get();
        } else {
            // Jika tidak ada query, ambil semua buku
            $buku = dm_buku::all();
        }
    
        // Filter buku untuk memastikan file PDF dan covernya ada
        $filteredBuku = $buku->filter(function ($book) {
            $pdfPath = 'public/pdf/' . $book->dbuku_file;
            $coverPath = 'public/cover/' . $book->dbuku_cover;
    
            // Periksa keberadaan file PDF
            if (\Storage::exists($pdfPath)) {
                // Periksa keberadaan cover, gunakan default jika tidak ada
                if (\Storage::exists($coverPath)) {
                    $book->dbuku_cover = asset('storage/cover/' . $book->dbuku_cover);
                } else {
                    $book->dbuku_cover = asset('assets/images/buku/default.jpg');
                }
    
                return true; // File PDF ada, tetap tampilkan buku
            }
    
            return false; // File PDF tidak ada, hapus buku dari koleksi
        });
    
        return view('user.halaman_buku', [
            'buku' => $filteredBuku,
            'query' => $query
        ]);
    }
    
    public function penulisAsing()
    {
        // Mengambil data penulis yang tidak berasal dari Indonesia
        $penulisAsing = DB::table('dm_penulis')
            ->where('dpenulis_kewarganegaraan', '!=', 'Indonesia') // Tidak berasal dari Indonesia
            ->get();
    
        // Untuk setiap penulis, ambil maksimal 6 buku pertama
        $penulisAsing->each(function ($penulis) {
            $penulis->buku = DB::table('dm_buku')
                ->where('id_dpenulis', $penulis->id_dpenulis)
                ->whereNotNull('dbuku_file')
                ->limit(6)
                ->get();
            
            // Hitung total buku untuk menentukan apakah "See More" diperlukan
            $penulis->jumlahBuku = DB::table('dm_buku')
                ->where('id_dpenulis', $penulis->id_dpenulis)
                ->count();
        });
    
        return view('user.halaman_penulis_asing', compact('penulisAsing'));
    }
    public function loadMoreBooksAsing(Request $request)
    {
        // Ambil buku tambahan berdasarkan offset dan id penulis
        $buku = DB::table('dm_buku')
            ->where('id_dpenulis', $request->id_dpenulis)
            ->offset($request->offset)
            ->limit(6)
            ->get();
    
        return response()->json($buku);
    }
    
        public function penulisLokal()
        {
            // Mengambil data penulis asal Indonesia
            $penulisLokal = DB::table('dm_penulis')
                ->where('dpenulis_kewarganegaraan', 'Indonesia')
                ->get();
    
            // Untuk setiap penulis, ambil maksimal 6 buku pertama
            $penulisLokal->each(function ($penulis) {
                $penulis->buku = DB::table('dm_buku')
                    ->where('id_dpenulis', $penulis->id_dpenulis)
                    ->limit(6)
                    ->get();
                
                // Hitung total buku untuk menentukan apakah "See More" diperlukan
                $penulis->jumlahBuku = DB::table('dm_buku')
                    ->where('id_dpenulis', $penulis->id_dpenulis)
                    ->count();
            });
    
            return view('user.halaman_penulis_lokal', compact('penulisLokal'));
        }
    
        public function loadMoreBooks(Request $request)
        {
            // Ambil buku tambahan berdasarkan offset dan id penulis
            $buku = DB::table('dm_buku')
                ->where('id_dpenulis', $request->id_dpenulis)
                ->offset($request->offset)
                ->limit(6)
                ->get();
    
            return response()->json($buku);
        
    } 
    public function loadMoreBooksFav(Request $request)
    {
        // Validasi parameter
        if (!$request->has('offset') || !$request->has('id_dpenulis')) {
            return response()->json([], 400);
        }
    
        // Mengambil data buku sesuai offset
        $buku = DB::table('dm_buku')
            ->where('id_dpenulis', $request->id_dpenulis)
            ->offset($request->offset)
            ->limit(6)
            ->get();
        
        return response()->json($buku);
    }
    
    
    public function penulisFavorit()
    {
        $penulisFavorit = DB::table('dm_penulis')
            ->join('dm_buku', 'dm_penulis.id_dpenulis', '=', 'dm_buku.id_dpenulis')
            ->join('trks_transaksi', 'dm_buku.id_dbuku', '=', 'trks_transaksi.id_dbuku')
            ->select('dm_penulis.*', DB::raw('COUNT(trks_transaksi.id_trks) as total_peminjaman'))
            ->groupBy('dm_penulis.id_dpenulis')
            ->orderByDesc('total_peminjaman')
            ->limit(5)
            ->get();
    
        $penulisFavorit->each(function ($penulis) {
            $penulis->buku = DB::table('dm_buku')
                ->where('id_dpenulis', $penulis->id_dpenulis)
                ->limit(6)
                ->get();
        });
    
        return view('user.halaman_penulis_fav', compact('penulisFavorit'));
    }}
