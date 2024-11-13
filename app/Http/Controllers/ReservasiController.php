<?php

namespace App\Http\Controllers;

use App\Models\dm_buku;
use App\Models\trks_reservasis;
use App\Models\User;
use App\Models\dm_salinan_buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReservasiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $reservasi = trks_reservasis::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
                ->join('users', 'users.id_usr', '=', 'trks_reservasis.id_usr')
                ->select('users.usr_nama', 'trks_reservasis.id_trsv', 'dm_buku.dbuku_judul', 'trks_reservasis.trsv_tgl_reservasi', 'trks_reservasis.trsv_tgl_kadaluarsa', 'trks_reservasis.trsv_tgl_pemberitahuan', 'trks_reservasis.trsv_tgl_pengambilan', 'trks_reservasis.trsv_status')
                ->whereNull('trks_reservasis.deleted_at')
                ->get();

            return DataTables::of($reservasi)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = "";
                    if ($row->trsv_status == 1) {
                        $btn .= '<div class="d-flex mr-2 gap-1">
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm editReservasi mr-2"
                            data-id="' . Crypt::encryptString($row->id_trsv) . '"
                            data-bs-toggle="modal"
                            data-bs-target="#editReservasi">
                            <i class="bi bi-pencil"></i>
                        </a>';
                    }
                    if ((in_array($row->trsv_status, [-1, 0, 2]))) {
                        $btn .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm modalShow"  data-id="' . Crypt::encryptString($row->id_trsv) . '" data-bs-toggle="modal" data-bs-target="#show"><i class="bi bi-eye"></i></a>';
                    }
                    if ($row->trsv_status == 1) {
                        $btn .= ' | <a href="javascript:void(0)" id="btn-batal"
                                    data-id="' . Crypt::encryptString($row->id_trsv) . '"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-lg"></i>
                                </a>';
                    }

                    $btn .= '</div>';
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
                'id_usr' => 'required',
                'trks_tgl_reservasi' => 'required|date|after_or_equal:today',
                'trsv_tgl_kadaluarsa' => 'required|date|after_or_equal:trks_tgl_reservasi',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus pilih.',
                'id_usr.required' => 'Peminjam harus pilih.',
                'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
                'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
                'trks_tgl_reservasi.after_or_equal' => 'Tanggal reservasi harus setelah atau sama dengan hari ini.',
                'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
                'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
                'trsv_tgl_kadaluarsa.after_or_equal' => 'Tanggal kadaluarsa harus setelah atau sama dengan tanggal reservasi.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $buku = Crypt::decryptString($request->id_dbuku);
            $user = Crypt::decryptString($request->id_usr);
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
                    $reservasi->id_usr = $user;
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
                        $reservasi->id_usr = $user;
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
            $data = trks_reservasis::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
                ->where('trks_reservasis.id_usr', $id_peminjam)
                ->where('trks_reservasis.trsv_status', 1)
                ->select('trks_reservasis.id_dbuku', 'dm_buku.dbuku_judul')
                ->get()
                ->map(function ($data) {
                    $data->id_dbuku = Crypt::encryptString($data->id_dbuku);
                    return $data;
                });
            return  response()->json($data);
        } elseif ($request->type === 'buku') {
            $id_dbuku = Crypt::decryptString($request->id_dbuku);
            $data = dm_buku::join('trks_reservasis', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
                ->where('trks_reservasis.id_dbuku', $id_dbuku)
                ->where('trks_reservasis.trsv_status', 1)
                ->select('trks_reservasis.trsv_tgl_reservasi', 'trks_reservasis.id_trsv', 'trks_reservasis.trsv_tgl_kadaluarsa')->first();
            $data->id_trsv = Crypt::encryptString($data->id_trsv);
            return  response()->json($data);
        } else {
            $id_trsv = Crypt::decryptString($request->id_trsv);
            $data = trks_reservasis::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
                ->join('users', 'users.id_usr', '=', 'trks_reservasis.id_usr')
                ->where('trks_reservasis.id_trsv', $id_trsv)
                ->select('dm_buku.dbuku_judul', 'users.usr_nama', 'trks_reservasis.trsv_tgl_reservasi', 'trks_reservasis.trsv_tgl_kadaluarsa', 'trks_reservasis.trsv_tgl_pemberitahuan', 'trks_reservasis.trsv_tgl_pengambilan', 'trks_reservasis.trsv_status')
                ->first();
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
            $user = Crypt::decryptString($request->id_peminjam);
            // Cek ketersediaan buku
            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->where('dsbuku_status', 0)->orWhere('dsbuku_status', 2)->first();
            if ($dsbuku) {
                $transaksi = new Transaksi();
                $transaksi->id_dbuku = $buku;
                $transaksi->id_dsbuku = $dsbuku->id_dsbuku;
                $transaksi->id_usr = $user;
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
                    'message' => 'Buku yang anda reservasi belum tersedia, tunggu tanggal pemberitahuan!',
                ]);
            }
        } catch (\Exception $th) {
            throw $th;
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Dekripsi ID jika terenkripsi
            $id_trsv = Crypt::decryptString($id);
            $id_usr = Crypt::decryptString($request->id_usr);
            $id_dbuku = Crypt::decryptString($request->id_dbuku);

            // Validasi input data
            $rules = [
                'id_dbuku' => 'required',
                'id_usr' => 'required',
                'trsv_tgl_reservasi' => 'required|date',
                'trsv_tgl_kadaluarsa' => 'required|date|after_or_equal:trsv_tgl_reservasi',
                'trsv_tgl_pemberitahuan' => 'nullable|date',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus dipilih.',
                'id_usr.required' => 'Peminjam harus dipilih.',
                'trsv_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
                'trsv_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
                'trsv_tgl_kadaluarsa.required' => 'Tanggal kadaluarsa harus diisi.',
                'trsv_tgl_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
                'trsv_tgl_kadaluarsa.after_or_equal' => 'Tanggal kadaluarsa harus sama atau setelah tanggal reservasi.',
                'trsv_tgl_pemberitahuan.date' => 'Tanggal pemberitahuan harus berupa tanggal yang valid.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $reservasi = trks_reservasis::find($id_trsv);

            if (!$reservasi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data reservasi tidak ditemukan.'
                ], 404);
            }

            $reservasi->id_dbuku = $id_dbuku;
            $reservasi->id_usr = $id_usr;
            $reservasi->trsv_tgl_reservasi = $request->trsv_tgl_reservasi;
            $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
            $reservasi->trsv_tgl_pemberitahuan = $request->trsv_tgl_pemberitahuan;
            $reservasi->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data reservasi berhasil diupdate.',
                'reservasi' => $reservasi
            ]);
        } catch (\Exception $th) {
            // Menangani error dengan log
            Log::error($th->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data reservasi.',
            ], 500);
        }
    }

    public function detailUpdate($id)
    {
        $id_trsv = Crypt::decryptString($id);

        $reservasi['reservasi'] = trks_reservasis::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasis.id_dbuku')
            ->join('users', 'users.id_usr', '=', 'trks_reservasis.id_usr')
            ->select('trks_reservasis.*', 'dm_buku.dbuku_judul', 'users.usr_nama')
            ->where('trks_reservasis.id_trsv', $id_trsv)
            ->first();

        $db['buku'] = dm_buku::select('id_dbuku', 'dbuku_judul')->get();
        $db['usr'] = User::select('users.id_usr', 'users.usr_nama')->get();

        $options['buku'] = '';
        $options['usr'] = '';

        foreach ($db['buku'] as $buku) {
            $selected = ($buku->id_dbuku == $reservasi['reservasi']->id_dbuku) ? 'selected' : '';
            $options['buku'] .= '<option value="' . Crypt::encryptString($buku->id_dbuku) . '" ' . $selected . '>' . $buku->dbuku_judul . '</option>';
        }
        foreach ($db['usr'] as $usr) {
            $selected = ($usr->id_usr == $reservasi['reservasi']->id_usr) ? 'selected' : '';
            $options['usr'] .= '<option value="' . Crypt::encryptString($usr->id_usr) . '" ' . $selected . '>' . $usr->usr_nama . '</option>';
        }


        $transaksi['usr'] = $options['usr'];
        $transaksi['buku'] = $options['buku'];
        $transaksi['reservasi'] = $reservasi['reservasi'];

        return response()->json($transaksi);
    }

    public function batalReservasi(Request $request)
    {
        try {
            $id_trsv = Crypt::decryptString($request->id_trsv);
            $preservasi = trks_reservasis::find($id_trsv);
            $preservasi->trsv_status = -1;
            $preservasi->save();

            $jreservasi = trks_reservasis::where('id_dbuku', $preservasi->id_dbuku)->where('trsv_status', 1)->exists();
            $jtransaksi = Transaksi::where('id_dbuku', $preservasi->id_dbuku)->where('trks_status', 0)->exists();
            if (!$jreservasi && !$jtransaksi) {
                $pbuku = dm_buku::find($preservasi->id_dbuku);
                $pbuku->dbuku_flag = 0;
                $pbuku->save();
            }
            $dsbuku = dm_salinan_buku::where('id_dbuku', $preservasi->id_dbuku)->where('dsbuku_status', 2)->first();
            if ($dsbuku) {
                $dsbuku->dsbuku_flag = 0;
                $dsbuku->dsbuku_status = 0;
                $dsbuku->save();
            }
            return response()->json(['message' => 'Buku reservasi dibatalkan!']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
