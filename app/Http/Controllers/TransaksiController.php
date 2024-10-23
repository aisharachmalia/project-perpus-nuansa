<?php

namespace App\Http\Controllers;

use App\Models\dm_buku;
use App\Models\dm_pustakawan;
use App\Models\dm_salinan_buku;
use App\Models\Dm_siswa;
use App\Models\Transaksi;
use App\Models\Trks_denda;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $transaksi = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_denda', 'trks_transaksi.trks_tgl_jatuh_tempo', 'dm_buku.dbuku_judul', 'users.usr_nama', 'trks_transaksi.trks_status')
                ->whereNull('trks_transaksi.deleted_at')
                ->get();

            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                <a href="javascript:void(0)" class="btn btn-warning btn-sm editPeminjaman mr-2" data-id="' . Crypt::encryptString($row->id_trks) . '" data-bs-toggle="modal" data-bs-target="#editPeminjaman">
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
        $buku = dm_buku::select('dm_buku.id_dbuku', 'dm_buku.dbuku_judul')->join('dm_salinan_bukus', 'dm_buku.id_dbuku', '=', 'dm_salinan_bukus.id_dbuku')->get();
        $siswa = User::join('trks_transaksi', 'users.id_usr', '=', 'trks_transaksi.id_usr')
            ->whereNull('trks_transaksi.trks_tgl_pengembalian')
            ->groupBy('users.id_usr')
            ->select('users.id_usr', 'users.usr_nama')->get();
        $siswa2 = User::select('id_usr', 'usr_nama')->get();
        $pustakawan = dm_pustakawan::select('id_dpustakawan', 'dpustakawan_nama')->get();
        return view('transaksi.transaksi', compact('buku', 'siswa', 'pustakawan', 'siswa2'));
    }

    // Fungsi untuk create peminjaman
    public function createPeminjaman(Request $request)
    {
        try {
            $rules = [
                'id_dbuku' => 'required',
                'id_dsiswa' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_peminjaman' => 'required|date|date_equals:today',
                'trks_tgl_jatuh_tempo' => 'required|date|after_or_equal:today',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus diisi.',
                'id_dsiswa.required' => 'Peminjam harus di isi!.',
                'id_dpustakawan.required' => 'Pustakawan harus diisi.',
                'trks_tgl_peminjaman.required' => 'Tanggal peminjaman harus diisi.',
                'trks_tgl_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid.',
                'trks_tgl_peminjaman.date_equals' => 'Tanggal peminjaman harus hari ini.',
                'trks_tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi.',
                'trks_tgl_jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
                'trks_tgl_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus hari ini atau setelahnya.',
            ];
            $validated = $request->validate($rules, $messages);

            $buku = Crypt::decryptString($request->id_dbuku);
            $siswa = Crypt::decryptString($request->id_dsiswa);
            $pustakawan = Crypt::decryptString($request->id_dpustakawan);
            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->get();
            $id_dsbuku = $dsbuku->where('dsbuku_status', 0)->first();
            if ($id_dsbuku) {
                // transaksi
                $transaksi = new Transaksi();
                $transaksi->id_dbuku = $buku;
                $transaksi->id_dsbuku = $id_dsbuku->id_dsbuku;
                $transaksi->id_usr = $siswa;
                $transaksi->id_dpustakawan = $pustakawan;
                $transaksi->trks_tgl_peminjaman = $request->trks_tgl_peminjaman;
                $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jatuh_tempo;
                $transaksi->save();
                // dsbuku
                $id_dsbuku->dsbuku_status = 1;
                $id_dsbuku->dsbuku_flag = 1;
                $id_dsbuku->save();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Buku sedang dipinjam!',
                ]);
            }
            // $siswaDet = Dm_siswa::where('id_dsiswa', $siswa)->select('dsiswa_email', 'dsiswa_nama')->first();
            // $namaBuku = DB::table('dm_buku')->where('id_dbuku', $buku)->select('dbuku_judul')->first();

            // // Kirim transaksi
            // $array = [
            //     'receive' => $siswaDet->dsiswa_email,  // Gunakan email siswa yang sudah diambil dari database
            //     'subject' => 'Peminjaman Buku',
            //     'data' => [
            //         'dbuku_judul' => $namaBuku->dbuku_judul,
            //         'dsiswa_nama' => $siswaDet->dsiswa_nama,
            //         'trks_tgl_peminjaman' => $transaksi->trks_tgl_peminjaman,
            //         'trks_tgl_jatuh_tempo' => $transaksi->trks_tgl_jatuh_tempo,
            //     ],
            // ];

            // Mail::send('mail.transaksi_buku', $array, function ($message) use ($array) {
            //     $message->to($array['receive'])
            //         ->subject($array['subject']);
            //     $message->from('perpustakaansmk@gmail.com', 'Perpustakaan SMK');
            // });

            return response()->json(['message' => 'Data transaksi berhasil disimpan']);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    // Fungsi untuk edit peminjaman
    public function editPeminjaman(Request $request, $id)
    {
        $id_trks = Crypt::decryptString($id);

        $rules = [
            'id_dbuku' => 'required',
            'trks_tgl_peminjaman' => 'required|date',
            'trks_tgl_jatuh_tempo' => 'required|date',
            'trks_tgl_pengembalian' => 'required|date',
            'trks_denda' => 'required|numeric',
            'trks_keterangan' => 'required',
        ];

        $messages = [
            'id_dbuku.required' => 'Buku harus dipilih!',
            'trks_tgl_peminjaman.required' => 'Tanggal pinjam harus diisi!',
            'trks_tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
            'trks_tgl_pengembalian.required' => 'Tanggal pengembalian harus diisi!',
            'trks_denda.required' => 'Nominal denda harus diisi!',
            'trks_keterangan.required' => 'Keterangan harus diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $id_dbuku = Crypt::decryptString($request->id_dbuku);
        Transaksi::where('id_trks', $id_trks)->update([
            'id_dbuku' => $id_dbuku,
            'trks_tgl_peminjaman' => $request->trks_tgl_peminjaman,
            'trks_tgl_jatuh_tempo' => $request->trks_tgl_jatuh_tempo,
            'trks_tgl_pengembalian' => $request->trks_tgl_pengembalian,
            'trks_denda' => $request->trks_denda,
            'trks_keterangan' => $request->trks_keterangan,
            'trks_status' => $request->trks_status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman Berhasil Diedit!',
        ]);
    }
    // Fungsi untuk create pengembalian
    public function pengembalian(Request $request, $id = null)
    {
        try {
            $request->validate([
                'siswa' => 'required',
                'denda' => 'numeric|min:0',
                'buku' => 'required',
                'jatuh_tempo' => 'required|date|after_or_equal:peminjaman',
                'peminjaman' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
                'tanggal_pengembalian' => 'required|date|after_or_equal:peminjaman',
            ], [
                'siswa.required' => 'Siswa wajib dipilih.',

                'denda.numeric' => 'Denda harus berupa angka.',
                'denda.min' => 'Denda tidak boleh kurang dari 0.',

                'buku.required' => 'Buku wajib dipilih.',

                'jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi.',
                'jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
                'jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus sama atau setelah tanggal peminjaman.',

                'peminjaman.required' => 'Tanggal peminjaman wajib diisi.',
                'peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid.',

                'keterangan.string' => 'Keterangan harus berupa teks.',
                'keterangan.max' => 'Keterangan maksimal 255 karakter.',

                'tanggal_pengembalian.required' => 'Tanggal pengembalian wajib diisi.',
                'tanggal_pengembalian.date' => 'Tanggal pengembalian harus berupa tanggal yang valid.',
                'tanggal_pengembalian.after_or_equal' => 'Tanggal pengembalian harus sama atau setelah tanggal peminjaman.',
            ]);

            if ($request->denda != 0) {
                Trks_denda::create([
                    'id_trks' => $id,
                    'tdenda_jumlah' => $request->denda,
                    'tdenda_status' => "Belum Dibayar",
                ]);
            }

            Transaksi::where('id_trks', $id)->update([
                'trks_tgl_pengembalian' => $request->tanggal_pengembalian,
                'trks_denda' => $request->denda,
                'trks_keterangan' => $request->keterangan,
                'trks_status' => 2,
            ]);
            $siswaDet = Transaksi::where('id_trks', $id)->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')->select('dm_siswas.dsiswa_email', 'dm_buku.dbuku_judul', 'dm_siswas.dsiswa_nama')->first();

            $array = [
                'receive' => $siswaDet->dsiswa_email,  // Gunakan email siswa yang sudah diambil dari database
                'subject' => 'Pengembalian Buku',
                'data' => [
                    'dbuku_judul' => $siswaDet->dbuku_judul,
                    'dsiswa_nama' => $siswaDet->dsiswa_nama,
                    'trks_tgl_peminjaman' => $request->peminjaman,
                    'trks_tgl_jatuh_tempo' => $request->jatuh_tempo,
                    'trks_tgl_pengembalian' => $request->tanggal_pengembalian,
                    'trks_denda' => $request->denda,
                    'trks_keterangan' => $request->keterangan,
                ],
            ];

            Mail::send('mail.pengembalian_buku', $array, function ($message) use ($array) {
                $message->to($array['receive'])
                    ->subject($array['subject']);
                $message->from('perpustakaansmk@gmail.com', 'Perpustakaan SMK');
            });

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian Berhasil Disimpan!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $siswaId = Crypt::decryptString($id);
        $transaksi = Dm_siswa::join('trks_transaksi', 'dm_siswas.id_dsiswa', '=', 'trks_transaksi.id_dsiswa')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_pustakawan', 'trks_transaksi.id_dpustakawan', '=', 'dm_pustakawan.id_dpustakawan')
            ->where('dm_siswas.id_dsiswa', $siswaId)
            ->whereNull('trks_transaksi.trks_tgl_pengembalian')
            ->whereNull('trks_transaksi.deleted_at')
            ->select(
                'trks_transaksi.trks_tgl_peminjaman',
                'trks_transaksi.trks_tgl_jatuh_tempo',
                'trks_transaksi.trks_tgl_pengembalian',
                'dm_buku.dbuku_judul',
                'trks_transaksi.id_trks',
                'dm_siswas.dsiswa_nama',
                'dm_pustakawan.dpustakawan_nama'
            )
            ->get()
            ->map(function ($transaksi) {
                // Enkripsi ID buku
                $transaksi->id_trks = Crypt::encryptString($transaksi->id_trks);
                return $transaksi;
            });
        return response()->json($transaksi);
    }


    public function detailBuku($id = null, $tanggalKembali = null)
    {
        try {
            $idTrks = Crypt::decryptString($id);
            $data['buku'] = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
                ->where('trks_transaksi.id_trks', $idTrks)
                ->whereNull('trks_transaksi.deleted_at')
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_transaksi.id_trks')
                ->first();
            if ($tanggalKembali > $data['buku']->trks_tgl_jatuh_tempo) {
                $data['denda'] = 10000;
            } else {
                $data['denda'] = 0;
            }
            return Response::json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function delete($id)
    {
        $id_trks = Crypt::decryptString($id);
        $transaksi = Transaksi::where('id_trks', $id_trks)->first();
        $transaksi->deleted_at = Carbon::now();
        $transaksi->save();
        return response()->json(['message' => 'Data transaksi berhasil dihapus']);
    }



    public function showModalEdit($id)
    {
        $transaksiId = Crypt::decryptString($id);
        $transaksi = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
            ->join('dm_pustakawan', 'trks_transaksi.id_dpustakawan', '=', 'dm_pustakawan.id_dpustakawan')
            ->where('trks_transaksi.id_trks', $transaksiId)
            ->select(
                'trks_transaksi.trks_tgl_peminjaman',
                'trks_transaksi.trks_tgl_jatuh_tempo',
                'trks_transaksi.trks_tgl_pengembalian',
                'dm_buku.id_dbuku',
                'dm_siswas.dsiswa_nama',
                'dm_pustakawan.dpustakawan_nama',
                'trks_transaksi.trks_denda',
                'trks_transaksi.trks_keterangan',
                'trks_transaksi.trks_status'
            )
            ->get()
            ->map(function ($transaksi) {
                // Enkripsi ID buku
                $transaksi->id_dbuku = Crypt::encryptString($transaksi->id_dbuku);
                return $transaksi;
            });
        return response()->json($transaksi);
    }
}
