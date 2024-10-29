<?php

namespace App\Http\Controllers;

use App\Models\trks_reservasis;
use App\Models\dm_salinan_buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReservasiController extends Controller
{
    public function index()
{
    if (request()->ajax()) {
        $reservasi = trks_reservasis::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
            ->join('users', 'users.id_usr', '=', 'trks_reservasis.id_usr')
            ->select('users.usr_nama', 'dm_buku.dbuku_judul', 'trks_reservasis.trsv_tgl_reservasi', 'trks_reservasis.trsv_tgl_kadaluarsa', 'trks_reservasis.trsv_tgl_pemberitahuan', 'trks_reservasis.trsv_tgl_pengambilan', 'trks_reservasis.trsv_status')
            ->whereNull('trks_reservasis.deleted_at')
            ->get();

        return DataTables::of($reservasi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="d-flex mr-2">
                <a href="javascript:void(0)" class="btn btn-warning btn-sm editPeminjaman mr-2" data-id="' . Crypt::encryptString($row->id_trsv) . '" data-bs-toggle="modal" data-bs-target="#editPeminjaman">
                    <i class="bi bi-pencil"></i>
                </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_trks) . '" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                </a>
                </div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}



    public function createReservasi(Request $request)
{
    try {
        $rules = [
            'id_dbuku' => 'required',
            'id_dsiswa' => 'required',
            'trks_tgl_reservasi' => 'required|date|after_or_equal:today',
            'trsv_tgl_kadaluarsa' => 'required|date|after:trks_tgl_reservasi',
        ];

        $messages = [
            'id_dbuku.required' => 'Buku harus diisi.',
            'id_dsiswa.required' => 'Peminjam harus diisi.',
            'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
            'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
            'trks_tgl_reservasi.after_or_equal' => 'Tanggal reservasi harus hari ini atau setelahnya.',
            'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
            'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
            'trsv_tgl_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah tanggal reservasi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $buku = Crypt::decryptString($request->id_dbuku);
        $siswa = Crypt::decryptString($request->id_dsiswa);
        // $pustakawan = Crypt::decryptString($request->id_dpustakawan);

        // Cek ketersediaan buku
        $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->where('dsbuku_status', 0)->first();
        if ($dsbuku) {
            // Buat reservasi baru
            $reservasi = new trks_reservasis();
            $reservasi->id_dbuku = $buku;
            $reservasi->id_dsbuku = $dsbuku->id_dsbuku;
            $reservasi->id_usr = $siswa;
            // $reservasi->id_dpustakawan = $pustakawan;
            $reservasi->trsv_tgl_reservasi = $request->trks_tgl_reservasi;
            $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
            $reservasi->save();

            return response()->json(['message' => 'Reservasi berhasil disimpan']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Buku sedang tidak tersedia untuk reservasi!',
            ]);
        }
    } catch (\Exception $th) {
        throw $th;
    }
}

public function createPengambilan(Request $request)
{
    try {
        $rules = [
            'id_dbuku' => 'required',
            'id_dsiswa' => 'required',
            'trks_tgl_reservasi' => 'required|date|after_or_equal:today',
            'trsv_tgl_kadaluarsa' => 'required|date|after:trks_tgl_reservasi',
            'trks_tgl_pemberitahuan' => 'required|date|after_or_equal:today',
            'trsv_tgl_pengambilan' => 'required|date|after:trks_tgl_reservasi',
        ];

        $messages = [
            'id_dbuku.required' => 'Buku harus diisi.',
            'id_dsiswa.required' => 'Peminjam harus diisi.',
            'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
            'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
            'trks_tgl_reservasi.after_or_equal' => 'Tanggal reservasi harus hari ini atau setelahnya.',
            'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
            'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
            'trsv_tgl_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah tanggal reservasi.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $buku = Crypt::decryptString($request->id_dbuku);
        $siswa = Crypt::decryptString($request->id_dsiswa);

        // Cek ketersediaan buku
        $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->where('dsbuku_status', 0)->first();
        if ($dsbuku) {
            // Buat reservasi baru
            $reservasi = new trks_reservasis();
            $reservasi->id_dbuku = $buku;
            $reservasi->id_dsbuku = $dsbuku->id_dsbuku;
            $reservasi->id_usr = $siswa;
            $reservasi->trsv_tgl_reservasi = $request->trks_tgl_reservasi;
            $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
            $reservasi->trsv_tgl_pemberitahuan = $request->trks_tgl_pemberitahuan;
            $reservasi->trsv_tgl_pengambilan = $request->trsv_tgl_pengambilan;
            $reservasi->trsv_status = 2;
            $reservasi->save();

            return response()->json(['message' => 'Reservasi berhasil disimpan']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Buku sedang tidak tersedia untuk reservasi!',
            ]);
        }
    } catch (\Exception $th) {
        throw $th;
    }
}

}
