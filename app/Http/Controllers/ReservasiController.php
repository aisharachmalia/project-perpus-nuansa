<?php

namespace App\Http\Controllers;

use App\Models\dm_buku;
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
                'trks_tgl_reservasi' => 'required|date',
                'trsv_tgl_kadaluarsa' => 'required|date',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus pilih.',
                'id_dsiswa.required' => 'Peminjam harus pilih.',
                'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
                'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
                'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
                'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
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
            $cbuku = dm_salinan_buku::where('id_dbuku', $buku)
                ->where('dsbuku_kondisi', '!=', 'Hilang')
                ->count();

            $cresevasi = trks_reservasis::where('id_dbuku', $buku)
                ->where('trsv_status', 1)
                ->count();

            // Cek ketersediaan buku
            if ($cbuku - $cresevasi > 0) {
                $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)
                    ->where('dsbuku_status', 0)
                    ->first();

                if ($dsbuku) {
                    // Buat reservasi baru
                    $reservasi = new trks_reservasis();
                    $reservasi->id_dbuku = $buku;
                    $reservasi->id_dsbuku = 0;
                    $reservasi->id_usr = $siswa;
                    $reservasi->trsv_tgl_reservasi = $request->trks_tgl_reservasi;
                    $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
                    $reservasi->save();

                    // Update status buku
                    $dsbuku->dsbuku_status = 2;
                    $dsbuku->dsbuku_flag = 1;
                    $dsbuku->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Reservasi berhasil dibuat untuk buku ini.'
                    ]);
                } else {
                    $dsbuku = Transaksi::join('dm_salinan_bukus', 'dm_salinan_bukus.id_dbuku', '=', 'trks_transaksi.id_dbuku')
                        ->join('dm_buku', 'dm_buku.id_dbuku', '=', 'dm_salinan_bukus.id_dbuku')
                        ->where('dm_buku.id_dbuku', $buku)
                        ->whereRaw("DATE_FORMAT(trks_transaksi.trks_tgl_jatuh_tempo, '%Y-%m-%d') <= ?", $request->trks_tgl_reservasi)
                        ->first();

                    if ($dsbuku) {
                        $reservasi = new trks_reservasis();
                        $reservasi->id_dbuku = $buku;
                        $reservasi->id_dsbuku = 0;
                        $reservasi->id_usr = $siswa;
                        $reservasi->trsv_tgl_reservasi = $request->trks_tgl_reservasi;
                        $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
                        $reservasi->save();

                        return response()->json([
                            'success' => true,
                            'message' => 'Reservasi berhasil dibuat untuk buku ini.'
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Saat ini, buku ini tidak tersedia untuk reservasi. Silakan coba lagi nanti.'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada lagi buku yang tersedia untuk reservasi. Reservasi sudah penuh!'
                ]);
            }
        } catch (\Exception $th) {
            throw $th;
        }
    }
    public function detailReservasi(Request $request)
    {
        if ($request->type === 'peminjam') {

            $id_peminjam = Crypt::decryptString($request->id_peminjam);
            $data = dm_buku::join('trks_reservasis', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
                ->where('trks_reservasis.id_usr', $id_peminjam)
                ->select('trks_reservasis.id_trsv', 'dm_buku.dbuku_judul')
                ->get()
                ->map(function ($data) {
                    $data->id_trsv = Crypt::encryptString($data->id_trsv);
                    return $data;
                });
            return  response()->json($data);
        } else {

            $id_trsv = Crypt::decryptString($request->id_trsv);
            $data = trks_reservasis::find($id_trsv)->join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')->select('trks_reservasis.trsv_tgl_reservasi', 'trks_reservasis.trsv_tgl_kadaluarsa', 'dm_buku.id_dbuku')->first();
            $data->id_dbuku = Crypt::encryptString($data->id_dbuku);
            return  response()->json($data);
        }
    }

    public function createPengambilan(Request $request)
    {
        try {
            $rules = [
                'id_dbuku' => 'required',
                'trks_tgl_jth_tempo' => 'required|date',
                'id_peminjam' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_reservasi' => 'required|date',
                'trsv_tgl_kadaluarsa' => 'required|date',
                'trsv_tgl_pengambilan' => 'required|date',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus dipilih.',
                'id_dpustakawan.required' => 'Pustakawan harus dipilih.',
                'id_peminjam.required' => 'Peminjam harus dipilih.',
                'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
                'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
                'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
                'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
                'trsv_tgl_pengambilan.required' => 'Tanggal pengambilan harus diisi.',
                'trsv_tgl_pengambilan.date' => 'Tanggal pengambilan harus berupa tanggal yang valid.',
                'trks_tgl_jth_tempo.required' => 'Tanggal jatuh tempo harus diisi.',
                'trks_tgl_jth_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $buku = Crypt::decryptString($request->id_dbuku);
            $siswa = Crypt::decryptString($request->id_peminjam);

            // Cek ketersediaan buku
            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->where('dsbuku_status', 0)->orWhere('dsbuku_status', 2)->first();
            if ($dsbuku) {
                $transaksi = new Transaksi();
                $transaksi->id_dbuku = $buku;
                $transaksi->id_dsbuku = $dsbuku->id_dsbuku;
                $transaksi->id_usr = $siswa;
                $transaksi->id_dpustakawan = Crypt::decryptString($request->id_dpustakawan);
                $transaksi->trks_tgl_peminjaman = $request->trks_tgl_reservasi;
                $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jth_tempo;
                $transaksi->save();

                $preservasi = trks_reservasis::find(Crypt::decryptString($request->id_trsv));
                $preservasi->trsv_status = 2;
                $preservasi->trsv_tgl_pengambilan = $request->trsv_tgl_pengambilan;
                $preservasi->save();

                $dsbuku->dsbuku_status = 1;
                $dsbuku->save();

                return response()->json(['message' => 'Buku reservasi berhasil diambil!']);
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
