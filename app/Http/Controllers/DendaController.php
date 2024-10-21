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
            ->whereNotNull('trks_transaksi.trks_tgl_pengembalian')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->select('dm_siswas.dsiswa_nama', 'dm_siswas.id_dsiswa')
            ->groupBy('dm_siswas.id_dsiswa')
            ->get();
        return view('denda.index', compact('siswa'));
    }

    public function table()
    {
        $denda = DB::table('trks_transaksi')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->orderBy('trks_denda.id_tdenda', 'desc')
            ->select('dm_buku.dbuku_judul', 'trks_denda.jumlah', 'trks_denda.status',  'dm_siswas.dsiswa_nama')
            ->get();
        return DataTables::of($denda)
            ->addIndexColumn()
            ->editColumn('jumlah', function ($row) {
                return 'Rp. ' . number_format($row->tdenda_jumlah, 0, ',', '.');
            })
            ->make(true);
    }
    public function detail($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $data['buku'] = DB::table('trks_transaksi')
                ->where('trks_transaksi.id_dsiswa', $id)
                ->whereNotNull('trks_transaksi.trks_tgl_pengembalian')
                ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
                ->whereNull('trks_denda.tdenda_tgl_bayar')
                ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->select('trks_denda.id_tdenda', 'dm_buku.dbuku_judul')
                ->get()
                ->map(function ($data) {
                    // Enkripsi ID buku
                    $data->id_tdenda = Crypt::encryptString($data->id_tdenda);
                    return $data;
                });
            return Response::json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function datailBuku($id = null)
    {
        try {
            $dendaId = Crypt::decryptString($id);
            $data = DB::table('trks_denda')
                ->where('trks_denda.id_tdenda', $dendaId)
                ->join('trks_transaksi', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_denda.tdenda_jumlah')
                ->first();
            return Response::json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function bayar(Request $request, $id = null)
    {
        try {
            // Validasi
            $rules = [
                'buku' => [
                    'required',
                ],
                'denda' => [
                    'required',
                    'min:0',
                ],
                'tanggal_pembayaran' => [
                    'required',
                    'date',
                    'after_or_equal:tanggal_jatuh_tempo',
                ],
            ];
            // Pesan kesalahan validasi
            $messages = [
                'buku.required' => 'Buku harus dipilih!',
                'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi!',
                'tanggal_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid!',
                'tanggal_peminjaman.before_or_equal' => 'Tanggal peminjaman tidak boleh setelah tanggal jatuh tempo!',
                'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
                'tanggal_jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid!',
                'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal peminjaman!',
                'denda.required' => 'Denda harus diisi!',
                'denda.min' => 'Denda tidak boleh negatif!',
                'tanggal_pembayaran.required' => 'Tanggal pembayaran harus diisi!',
                'tanggal_pembayaran.date' => 'Tanggal pembayaran harus berupa tanggal yang valid!',
                'tanggal_pembayaran.after_or_equal' => 'Tanggal pembayaran harus setelah tanggal jatuh tempo!',
            ];

            $validated = $request->validate($rules, $messages);
            $id = Crypt::decryptString($id);
            $denda = Trks_denda::find($id);
            $denda->tdenda_status = 'Sudah Lunas';
            $denda->tdenda_tgl_bayar = $request->tanggal_pembayaran;
            $denda->save();
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil Dilakukan!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
