<?php

namespace App\Http\Controllers;

use App\Models\Trks_denda;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class DendaController extends Controller
{


    public function index()
    {
        $siswa = Trks_denda::join('trks_transaksi', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->select('dm_siswas.dsiswa_nama', 'dm_siswas.id_dsiswa')
            ->whereIn('trks_denda.tdenda_status', [0, 1])
            ->distinct()
            ->get();
        return view('denda.index', compact('siswa'));
    }

    public function table()
    {
        $denda = DB::table('trks_transaksi')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->select('dm_buku.dbuku_judul', 'trks_denda.tdenda_tgl_bayar', 'trks_denda.tdenda_jumlah', 'trks_denda.tdenda_status',  'dm_siswas.dsiswa_nama')
            ->distinct()
            ->get();
        return DataTables::of($denda)
            ->addIndexColumn()
            ->make(true);
    }
    public function detail($id)
    {
        $id = Crypt::decryptString($id);
        $data['denda'] = DB::table('trks_transaksi')
            ->where('trks_transaksi.id_dsiswa', $id)
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->select('dm_buku.dbuku_judul', 'trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_transaksi.trks_denda', 'trks_denda.id_tdenda')
            ->get()
            ->map(function ($data) {
                $data->id_tdenda = Crypt::encryptString($data->id_tdenda);
                return $data;
            });
        return Response::json($data);
    }

    public function bayar(Request $request, $id = null)
    {
        $id = Crypt::decryptString($id);
        $rules = [
            'buku' => [
                'required',
            ],
            'tanggal_peminjaman' => [
                'required',
                'date',
                'before_or_equal:tanggal_jatuh_tempo',
            ],
            'tanggal_jatuh_tempo' => [
                'required',
                'date',
                'after_or_equal:tanggal_peminjaman',
            ],
            'denda' => [
                'required',
                'min:0',
            ],
            'tanggal_pembayaran' => [
                'date',
                'after_or_equal:tanggal_jatuh_tempo',
            ],
        ];

        // Pesan kesalahan validasi
        $messages = [
            'buku.required' => 'Buku harus diisi!',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi!',
            'tanggal_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid!',
            'tanggal_peminjaman.before_or_equal' => 'Tanggal peminjaman tidak boleh setelah tanggal jatuh tempo!',
            'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
            'tanggal_jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid!',
            'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal peminjaman!',
            'denda.required' => 'Denda harus diisi!',
            'denda.min' => 'Denda tidak boleh negatif!',
            'tanggal_pembayaran.date' => 'Tanggal pembayaran harus berupa tanggal yang valid!',
            'tanggal_pembayaran.after_or_equal' => 'Tanggal pembayaran harus setelah tanggal jatuh tempo!',
        ];

        $validated = $request->validate($rules, $messages);
        $denda = Trks_denda::find($id);
        $denda->tdenda_status = 2;
        $denda->tdenda_tgl_bayar = $request->tanggal_pembayaran;
        $denda->save();
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran Berhasil Dilakukan!',
        ]);
    }
}
