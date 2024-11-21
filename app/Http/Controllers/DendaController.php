<?php

namespace App\Http\Controllers;

use App\Models\pembayaran;
use App\Models\Trks_denda;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class DendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $peminjam = Trks_denda::join('trks_transaksi', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->leftJoin('pembayarans', 'trks_denda.id_tdenda', '=', 'pembayarans.id_tdenda')
            ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
            ->whereRaw('trks_denda.jumlah - IFNULL(pembayarans.jumlah, 0) > 0')
            ->select('users.usr_nama', 'users.id_usr')
            ->groupBy('users.id_usr')
            ->get();
        return view('denda.index', compact('peminjam'));
    }

    public function table()
    {
        $denda = DB::table('trks_transaksi')
            ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
            ->leftJoin('pembayarans', 'trks_denda.id_tdenda', '=', 'pembayarans.id_tdenda')
            ->orderBy('trks_denda.id_tdenda', 'desc')
            ->select('dm_buku.dbuku_judul', 'trks_denda.jumlah', 'pembayarans.status', 'trks_denda.status as status_denda', 'pembayarans.jumlah as jumlah_bayar', 'users.usr_nama', 'pembayarans.tgl_pembayaran')
            ->get();

        return DataTables::of($denda)
            ->addIndexColumn()
            ->editColumn('jumlah', function ($row) {
                return 'Rp. ' . number_format($row->jumlah, 0, ',', '.');
            })
            ->editColumn('jumlah_bayar', function ($row) {
                return 'Rp. ' . number_format($row->jumlah_bayar, 0, ',', '.');
            })
            ->make(true);
    }
    public function detail($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $data = DB::table('trks_transaksi')
                ->where('trks_transaksi.id_usr', $id)
                ->join('trks_denda', 'trks_denda.id_trks', '=', 'trks_transaksi.id_trks')
                ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->where('trks_denda.status', 0)
                ->orderBy('trks_denda.id_tdenda', 'desc')
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
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_denda.jumlah')
                ->first();
            $pembayaran = pembayaran::where('id_tdenda', $dendaId)->select('jumlah')->first();
            $data->jumlah = $data->jumlah - ($pembayaran ? $pembayaran->jumlah : 0);
            return Response::json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function bayar(Request $request)
    {
        try {
            // Validasi
            $rules = [
                'buku' => [
                    'required',
                ],
                'user' => [
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
                ]
            ];
            // Pesan kesalahan validasi
            $messages = [
                'buku.required' => 'Buku harus dipilih!',
                'user.required' => 'User harus dipilih!',
                'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi!',
                'tanggal_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid!',
                'tanggal_peminjaman.before_or_equal' => 'Tanggal peminjaman tidak boleh setelah tanggal jatuh tempo!',
                'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
                'tanggal_jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid!',
                'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal peminjaman!',
                'denda.required' => 'Uang pembayaran harus diisi!',
                'denda.min' => 'Denda tidak boleh kurang dari 0!',
                'tanggal_pembayaran.required' => 'Tanggal pembayaran harus diisi!',
                'tanggal_pembayaran.date' => 'Tanggal pembayaran harus berupa tanggal yang valid!',
                'tanggal_pembayaran.after_or_equal' => 'Tanggal pembayaran harus setelah tanggal jatuh tempo!',
            ];

            $validated = $request->validate($rules, $messages);
            $id = Crypt::decryptString($request->id_denda);
            $id_usr = Crypt::decryptString($request->user);
            $denda = Trks_denda::find($id);
            $pemabayaran = pembayaran::where('id_tdenda', $id)->first();
            if (!$pemabayaran) {
                if ($denda->jumlah - $request->denda <= 0) {
                    pembayaran::create([
                        'id_usr' => $id_usr,
                        'id_tdenda' => $id,
                        'jumlah' => $request->denda,
                        'tgl_pembayaran' => $request->tanggal_pembayaran,
                        'status' => 1,
                    ]);
                    $denda->update([
                        'status' => 1
                    ]);
                } else {
                    pembayaran::create([
                        'id_usr' => $id_usr,
                        'id_tdenda' => $id,
                        'jumlah' => $request->denda,
                        'tgl_pembayaran' => $request->tanggal_pembayaran,
                        'status' => 0,
                    ]);
                }
            } else {
                if ($denda->jumlah - ($request->denda + $pemabayaran->jumlah) <= 0) {
                    $pemabayaran->update([
                        'id_usr' => $id_usr,
                        'id_tdenda' => $id,
                        'jumlah' => $pemabayaran->jumlah + $request->denda,
                        'tgl_pembayaran' => $request->tanggal_pembayaran,
                        'status' => 1,
                    ]);
                    $denda->update([
                        'status' => 1
                    ]);
                } else {
                    $pemabayaran->update([
                        'id_usr' => $id_usr,
                        'id_tdenda' => $id,
                        'jumlah' => $pemabayaran->jumlah + $request->denda,
                        'tgl_pembayaran' => $request->tanggal_pembayaran,
                        'status' => 0,
                    ]);
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil Dilakukan!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
