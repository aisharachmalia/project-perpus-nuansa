<?php

namespace App\Http\Controllers;

use App\Models\Dm_siswa;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah total siswa dari tabel dm_siswas
        $totalSiswa = Dm_siswa::whereNull('deleted_at')->count();
        $totalBuku = dm_buku::whereNull('deleted_at')->count();

        // Kirim hasil ke view
        return view('home', compact('totalSiswa,totalBuku'));
    }
}

