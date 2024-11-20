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
                ->orderBy('trks_reservasis.created_at', 'desc')
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
                'trsv_tgl_kadaluarsa' => 'required|date|after:trks_tgl_reservasi',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus pilih.',
                'id_usr.required' => 'Peminjam harus pilih.',
                'trks_tgl_reservasi.required' => 'Tanggal reservasi harus diisi.',
                'trks_tgl_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
                'trks_tgl_reservasi.after_or_equal' => 'Tanggal reservasi harus setelah atau sama dengan hari ini.',
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
            $user = Crypt::decryptString($request->id_usr);
            $tglReservasi = str_replace('T', ' ', $request->trks_tgl_reservasi);
            $jbuku = dm_salinan_buku::where('id_dbuku', $buku)->where('dsbuku_status', 0)->count();

            // Cari peminjaman dan reservasi terakhir
            $peminjaman = Transaksi::where("trks_status", 0)
                ->where("id_dbuku", $buku)
                ->whereNull('deleted_at')
                ->orderBy('trks_tgl_jatuh_tempo', 'desc')
                ->first();
            $trkhirReservasi = trks_reservasis::where('id_dbuku', $buku)
                ->where('trsv_status', 1)
                ->whereNull('deleted_at')
                ->orderBy('trsv_tgl_reservasi', 'desc')
                ->first();

            // Cek jika ada peminjaman aktif atau reservasi aktif
            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)
                ->where('dsbuku_status', 0)
                ->first();
            if ($jbuku > 0) {
                $reservasi = new trks_reservasis();
                $reservasi->id_dbuku = $buku;
                $reservasi->id_dsbuku = 0;
                $reservasi->id_usr = $user;
                $reservasi->trsv_tgl_reservasi = $tglReservasi;
                $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
                $reservasi->save();
                $tbuku = dm_buku::where('id_dbuku', $buku)->first();
                if ($dsbuku) {
                    $dsbuku->dsbuku_status = 2;
                    $dsbuku->dsbuku_flag = 1;
                    $dsbuku->save();
                    if ($tbuku->dbuku_jml_tersedia > 0) {
                        $tbuku->dbuku_jml_tersedia = $tbuku->dbuku_jml_tersedia - 1;
                        $tbuku->save();
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi berhasil dibuat untuk buku ini.'
                ]);
            }
            if (($peminjaman && $tglReservasi <= $peminjaman->trks_tgl_jatuh_tempo) ||
                ($trkhirReservasi && $tglReservasi <= $trkhirReservasi->trsv_tgl_kadaluarsa)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saat ini, buku ini tidak tersedia untuk reservasi. Silakan coba lagi nanti.'
                ]);
            }



            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)
                ->where('dsbuku_status', 0)
                ->first();
            $reservasi = new trks_reservasis();
            $reservasi->id_dbuku = $buku;
            $reservasi->id_dsbuku = 0;
            $reservasi->id_usr = $user;
            $reservasi->trsv_tgl_reservasi = $tglReservasi;
            $reservasi->trsv_tgl_kadaluarsa = $request->trsv_tgl_kadaluarsa;
            $reservasi->save();
            $tbuku = dm_buku::where('id_dbuku', $buku)->first();
            if ($tbuku->dbuku_jml_tersedia > 0) {
                $tbuku->dbuku_jml_tersedia = $tbuku->dbuku_jml_tersedia - 1;
                $tbuku->save();
            }
            if ($dsbuku) {
                $dsbuku->dsbuku_status = 2;
                $dsbuku->dsbuku_flag = 1;
                $dsbuku->save();
                if ($tbuku->dbuku_jml_tersedia > 0) {
                    $tbuku->dbuku_jml_tersedia = $tbuku->dbuku_jml_tersedia - 1;
                    $tbuku->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat untuk buku ini.'
            ]);
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
                ' trks_tgl_jth_tempo' => 'required|date|after:trsv_tgl_pengambilan',
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
                $transaksi->trks_tgl_peminjaman = $request->trsv_tgl_pengambilan;
                $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jth_tempo;
                $transaksi->save();

                $preservasi = trks_reservasis::find(Crypt::decryptString($request->id_trsv));
                $preservasi->trsv_status = 2;
                $preservasi->trsv_tgl_pengambilan = $request->trsv_tgl_pengambilan;
                $preservasi->save();

                $dsbuku->dsbuku_status = 1;
                $dsbuku->dsbuku_flag = 1;
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
            $dsbuku = dm_salinan_buku::where('id_dbuku', $id_dbuku)
                ->where('dsbuku_status', 0)
                ->first();
            $tbuku = dm_buku::find($id_dbuku);
            $bukulama=dm_buku::find($reservasi->id_dbuku);

            if (!$reservasi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data reservasi tidak ditemukan.'
                ], 404);
            }
            if ($reservasi->id_dbuku != $id_dbuku) {
                if ($bukulama->dbuku_jml_tersedia < $bukulama->dbuku_jml_total) {
                    $bukulama->dbuku_jml_tersedia = $bukulama->dbuku_jml_tersedia + 1;
                    $bukulama->save();
                }
                if ($dsbuku) {
                    $dsbuku->dsbuku_status = 2;
                    $dsbuku->dsbuku_flag = 1;
                    $dsbuku->save();
                    if ($tbuku->dbuku_jml_tersedia > 0) {
                        $tbuku->dbuku_jml_tersedia = $tbuku->dbuku_jml_tersedia - 1;
                        $tbuku->save();
                    }
                }
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
            throw $th;
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

    public function batalTransaksi(Request $request)
    {
        try {
            if ($request->type == "reservasi") {
                $id_trsv = Crypt::decryptString($request->id_trsv);
                $preservasi = trks_reservasis::find($id_trsv);
                $preservasi->trsv_status = -1;
                $preservasi->save();

                $jreservasi = trks_reservasis::where('id_dbuku', $preservasi->id_dbuku)->where('trsv_status', 1)->exists();
                $jtransaksi = Transaksi::where('id_dbuku', $preservasi->id_dbuku)->where('trks_status', 0)->exists();

                $dsbuku = dm_salinan_buku::where('id_dbuku', $preservasi->id_dbuku)->where('dsbuku_status', 2)->first();
                if ($dsbuku) {
                    $dsbuku->dsbuku_flag = 0;
                    $dsbuku->dsbuku_status = 0;
                    $dsbuku->save();
                    $pbuku = dm_buku::find($preservasi->id_dbuku);
                    if ($pbuku->dbuku_jml_tersedia < $pbuku->dbuku_jml_total) {
                        $pbuku->dbuku_jml_tersedia = $pbuku->dbuku_jml_tersedia + 1;
                        $pbuku->save();
                    }
                    if (!$jreservasi && !$jtransaksi) {
                        $pbuku->dbuku_flag = 0;
                        $pbuku->save();
                    }
                }
                return response()->json(['message' => 'Buku reservasi dibatalkan!']);
            } else {
                $id_trks = Crypt::decryptString($request->id_trks);
                $trks = Transaksi::find($id_trks);
                $buku = dm_buku::find($trks->id_dbuku);
                $dsbuku = dm_salinan_buku::find($trks->id_dsbuku);
                $dsbuku->dsbuku_status = 0;
                $dsbuku->save();

                $jreservasi = trks_reservasis::where('id_dbuku', $trks->id_dbuku)->where('trsv_status', 1)->exists();
                $jtransaksi = Transaksi::where('id_dbuku', $trks->id_dbuku)->where('trks_status', 0)->exists();
                $trks->trks_status = -1;
                $trks->save();
                if (!$jreservasi && !$jtransaksi) {
                    $buku->dbuku_flag = 0;
                    if ($buku->dbuku_jml_tersedia < $buku->dbuku_jml_total) {
                        $buku->dbuku_jml_tersedia = $buku->dbuku_jml_tersedia + 1;
                        $buku->save();
                    }
                    $buku->save();
                }

                return response()->json(['message' => 'Peminjaman buku dibatalkan!']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
