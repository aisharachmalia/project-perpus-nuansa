<?php

namespace App\Http\Controllers;
use App\Models\Dm_siswa;
use App\Models\dm_buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalSiswa = Dm_siswa::whereNull('deleted_at')->count();
        $totalBuku = Dm_buku::sum('dbuku_jml_total');
    
        // Mengirimkan total siswa dan total buku ke view
        return view('home', compact('totalSiswa', 'totalBuku'));
    }
    
}
