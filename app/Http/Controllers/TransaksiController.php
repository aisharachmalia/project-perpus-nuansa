<?php

namespace App\Http\Controllers;

use App\Models\dm_buku;
use App\Models\dm_pustakawan;
use App\Models\dm_salinan_buku;
use App\Models\Transaksi;
use App\Models\Trks_denda;
use App\Models\trks_reservasis;
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
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_denda', 'trks_transaksi.trks_tgl_pengembalian', 'trks_transaksi.trks_tgl_jatuh_tempo', 'dm_buku.dbuku_judul', 'users.usr_nama', 'trks_transaksi.trks_status', 'trks_transaksi.id_trks')
                ->whereNull('trks_transaksi.deleted_at')
                ->get();

            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btnClass = $row->trks_status <= 0 ? 'editPeminjaman' : 'editPengembalian';

                    $btn = '<div class="d-flex mr-2">
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm ' . $btnClass . ' mr-2"
                           data-id="' . Crypt::encryptString($row->id_trks) . '"
                           data-bs-toggle="modal" data-bs-target="#' . $btnClass . '">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->editColumn('trks_denda', function ($row) {
                    return 'Rp. ' . number_format($row->trks_denda, 0, ',', '.');
                })
                ->make(true);
        }
        $buku = dm_buku::select('dm_buku.id_dbuku', 'dm_buku.dbuku_judul')->groupBy('dm_buku.id_dbuku')->join('dm_salinan_bukus', 'dm_buku.id_dbuku', '=', 'dm_salinan_bukus.id_dbuku')->whereNull('dm_salinan_bukus.deleted_at')->where('dm_buku.dbuku_jml_tersedia', '!=', 0)->get();
        $bukuReservasi = dm_buku::select('dm_buku.id_dbuku', 'dm_buku.dbuku_judul')->groupBy('dm_buku.id_dbuku')->join('dm_salinan_bukus', 'dm_buku.id_dbuku', '=', 'dm_salinan_bukus.id_dbuku')->whereNull('dm_salinan_bukus.deleted_at')->get();
        $siswa = User::join('trks_transaksi', 'users.id_usr', '=', 'trks_transaksi.id_usr')
            ->whereNull('trks_transaksi.trks_tgl_pengembalian')
            ->whereNull('users.deleted_at')
            ->where('users.usr_stat', 1)
            ->groupBy('users.id_usr')
            ->select('users.id_usr', 'users.usr_nama')->get();
        $siswa2 = User::select('users.id_usr', 'users.usr_nama')
            ->leftJoin('akses_usrs', 'users.id_usr', '=', 'akses_usrs.id_usr')
            ->whereNull('akses_usrs.id_usr')
            ->whereNull('users.deleted_at')
            ->where('users.usr_stat', 1)
            ->get();

        $reservasi = User::join('trks_reservasis', 'users.id_usr', '=', 'trks_reservasis.id_usr')
            ->selectRaw('users.usr_nama, MIN(users.id_usr) as id_usr')
            ->whereNull('trks_reservasis.deleted_at')
            ->where('trks_reservasis.trsv_status', 1)
            ->groupBy('users.id_usr')
            ->get();
        $pustakawan = dm_pustakawan::select('id_dpustakawan', 'dpustakawan_nama')->get();
        return view('transaksi.transaksi', compact('buku', 'siswa', 'pustakawan', 'siswa2', 'bukuReservasi', 'reservasi'));
    }

    // Fungsi untuk create peminjaman
    public function createPeminjaman(Request $request)
    {
        try {
            $rules = [
                'id_dbuku' => 'required',
                'id_usr' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_peminjaman' => 'required|date|after_or_equal:today',
                'trks_tgl_jatuh_tempo' => 'required|date|after:trks_tgl_peminjaman',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus diisi.',
                'id_usr.required' => 'Peminjam harus di isi!.',
                'id_dpustakawan.required' => 'Pustakawan harus diisi.',
                'trks_tgl_peminjaman.required' => 'Tanggal peminjaman harus diisi.',
                'trks_tgl_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid.',
                'trks_tgl_peminjaman.after_or_equal' => 'Tanggal peminjaman harus hari ini.',
                'trks_tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi.',
                'trks_tgl_jatuh_tempo.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
                'trks_tgl_jatuh_tempo.after' => 'Tanggal atau jam jatuh tempo harus setelah tanggal peminjaman.',
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
            $pustakawan = Crypt::decryptString($request->id_dpustakawan);
            $dsbuku = dm_salinan_buku::where('id_dbuku', $buku)->first();

            // transaksi
            $transaksi = new Transaksi();
            $transaksi->id_dbuku = $buku;
            $transaksi->id_dsbuku = $dsbuku->id_dsbuku;
            $transaksi->id_usr = $user;
            $transaksi->id_dpustakawan = $pustakawan;
            $transaksi->trks_tgl_peminjaman = $request->trks_tgl_peminjaman;
            $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jatuh_tempo;
            $transaksi->save();
            // dsbuku
            $dsbuku->dsbuku_status = 1;
            $dsbuku->dsbuku_flag = 1;
            $dsbuku->save();
            // dm_buku
            $dm_buku = dm_buku::find($buku);
            $dm_buku->dbuku_flag = 1;
            $dm_buku->dbuku_jml_tersedia = $dm_buku->dbuku_jml_tersedia - 1;
            $dm_buku->save();


            // $userDet = User::where('id_usr', $user)->select('usr_email', 'usr_nama')->first();
            // $namaBuku = DB::table('dm_buku')->where('id_dbuku', $buku)->select('dbuku_judul')->first();

            // // Kirim transaksi
            // $array = [
            //     'receive' => $userDet->usr_email,
            //     'subject' => 'Peminjaman Buku',
            //     'data' => [
            //         'dbuku_judul' => $namaBuku->dbuku_judul,
            //         'usr_nama' => $userDet->usr_nama,
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
    public function editTransaksi(Request $request, $id)
    {
        $id_trks = Crypt::decryptString($id);

        if ($request->type == 'peminjaman') {
            $rules = [
                'id_dbuku' => 'required',
                'id_usr' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_peminjaman' => 'required|date|after_or_equal:today',
                'trks_tgl_jatuh_tempo' => 'required|date|after:trks_tgl_peminjaman',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus dipilih!',
                'id_usr.required' => 'Peminjam harus dipilih!',
                'id_dpustakawan.required' => 'Pustakawan harus dipilih!',
                'trks_tgl_peminjaman.required' => 'Tanggal pinjam harus diisi!',
                'trks_tgl_peminjaman.after_or_equal' => 'Tanggal peminjaman harus hari ini.',
                'trks_tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
                'trks_tgl_jatuh_tempo.after' => 'Tanggal atau jam jatuh tempo harus setelah tanggal peminjaman.',
            ];
        } else {
            $rules = [
                'id_dbuku' => 'required',
                'id_usr' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_peminjaman' => 'required|date',
                'trks_tgl_jatuh_tempo' => 'required|date',
                'trks_tgl_pengembalian' => 'required|date',
                'trks_denda' => 'required|numeric',
            ];

            $messages = [
                'id_dbuku.required' => 'Buku harus dipilih!',
                'id_usr.required' => 'Peminjam harus dipilih!',
                'id_dpustakawan.required' => 'Pustakawan harus dipilih!',
                'trks_tgl_peminjaman.required' => 'Tanggal pinjam harus diisi!',
                'trks_tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
                'trks_tgl_pengembalian.required' => 'Tanggal pengembalian harus diisi!',
                'trks_denda.required' => 'Nominal denda harus diisi!',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $id_dbuku = Crypt::decryptString($request->id_dbuku);
        $id_usr = Crypt::decryptString($request->id_usr);
        $id_dpustakawan = Crypt::decryptString($request->id_dpustakawan);
        $denda = Trks_denda::where('id_trks', $id_trks)->first();

        if ($request->trks_denda > 0) {
            if (!$denda) {
                Trks_denda::create([
                    'id_trks' => $id_trks,
                    'jumlah' => $request->trks_denda,
                    'status' => 0,
                ]);
            }
        }
        Transaksi::where('id_trks', $id_trks)->update([
            'id_dbuku' => $id_dbuku,
            'id_usr' => $id_usr,
            'id_dpustakawan' => $id_dpustakawan,
            'trks_tgl_peminjaman' => $request->trks_tgl_peminjaman,
            'trks_tgl_jatuh_tempo' => $request->trks_tgl_jatuh_tempo,
            'trks_tgl_pengembalian' => $request->trks_tgl_pengembalian,
            'trks_denda' => $request->trks_denda,
            'trks_keterangan' => $request->trks_keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman Berhasil Diedit!',
        ]);
    }
    // Fungsi untuk create pengembalian
    public function pengembalian(Request $request)
    {
        try {
            $request->validate([
                'id_usr' => 'required',
                'denda' => 'nullable|numeric|min:0',
                'buku' => 'required',
                'jatuh_tempo' => 'required|date|after_or_equal:peminjaman',
                'peminjaman' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
                'tanggal_pengembalian' => 'required|date|after_or_equal:peminjaman',
            ], [
                'id_usr.required' => 'Peminjam wajib dipilih.',

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
            $id_trks = crypt::decryptString($request->id_trks);
            if ($request->denda != 0) {
                Trks_denda::create([
                    'id_trks' => $id_trks,
                    'jumlah' => $request->denda,
                    'status' => 0,
                ]);
            }

            Transaksi::where('id_trks', $id_trks)->update([
                'trks_tgl_pengembalian' => $request->tanggal_pengembalian,
                'trks_denda' => $request->denda,
                'trks_keterangan' => $request->keterangan,
                'trks_status' => 1,
            ]);
            $transaksi = Transaksi::where('id_trks', $id_trks)->first();
            $reservasi = trks_reservasis::join('dm_buku', 'trks_reservasis.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->whereRaw("DATE_FORMAT(trks_reservasis.trsv_tgl_reservasi, '%Y-%m-%d %H:%i') >= ?", [$request->tanggal_pengembalian = str_replace('T', ' ', $request->tanggal_pengembalian)])
                ->where('trsv_status', 1)
                ->whereNull('trsv_tgl_pemberitahuan')
                ->first();

            if (!$reservasi) {
                dm_salinan_buku::where('id_dsbuku', $transaksi->id_dsbuku)->update([
                    'dsbuku_status' => 0,
                    'dsbuku_flag' => 0
                ]);
                $dm_buku = dm_buku::find($transaksi->id_dbuku);
                $dm_buku->dbuku_jml_tersedia = $dm_buku->dbuku_jml_tersedia + 1;
                $dm_buku->save();
            } else {
                dm_salinan_buku::where('id_dsbuku', $transaksi->id_dsbuku)->update([
                    'dsbuku_status' => 2,
                ]);
                $reservasi->trsv_tgl_pemberitahuan = Carbon::now('Asia/Jakarta');
                $reservasi->save();
                // $peminjamDet = User::where('id_usr', $reservasi->id_usr)->first();
                // $array = [
                //     'receive' => $peminjamDet->usr_email,
                //     'subject' => 'Reservasi Buku Tersedia',
                //     'data' => [
                //         'dbuku_judul' => $reservasi->dbuku_judul,
                //         'usr_nama' => $peminjamDet->usr_nama,
                //         'trsv_tgl_reservasi' => $reservasi->trsv_tgl_reservasi,
                //     ],
                // ];

                // Mail::send('mail.pengembalian_buku', $array, function ($message) use ($array) {
                //     $message->to($array['receive'])
                //         ->subject($array['subject']);
                //     $message->from('perpustakaansmk@gmail.com', 'Perpustakaan SMK');
                // });
            }


            // $peminjamDet = Transaksi::where('id_trks', $id_trks)->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')->select('users.usr_email', 'dm_buku.dbuku_judul', 'users.usr_nama')->first();

            // $array = [
            //     'receive' => $peminjamDet->usr_email,
            //     'subject' => 'Pengembalian Buku',
            //     'data' => [
            //         'dbuku_judul' => $peminjamDet->dbuku_judul,
            //         'usr_nama' => $peminjamDet->usr_nama,
            //         'trks_tgl_peminjaman' => $request->peminjaman,
            //         'trks_tgl_jatuh_tempo' => $request->jatuh_tempo,
            //         'trks_tgl_pengembalian' => $request->tanggal_pengembalian,
            //         'trks_denda' => number_format($request->denda, 0, ',', '.'),
            //         'trks_keterangan' => $request->keterangan,
            //     ],
            // ];

            // Mail::send('mail.pengembalian_buku', $array, function ($message) use ($array) {
            //     $message->to($array['receive'])
            //         ->subject($array['subject']);
            //     $message->from('perpustakaansmk@gmail.com', 'Perpustakaan SMK');
            // });

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian Buku Berhasil Disimpan!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail(Request $request)
    {
        $userId = Crypt::decryptString($request->id_usr);
        $transaksi = User::join('trks_transaksi', 'users.id_usr', '=', 'trks_transaksi.id_usr')
            ->join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->join('dm_pustakawan', 'trks_transaksi.id_dpustakawan', '=', 'dm_pustakawan.id_dpustakawan')
            ->where('users.id_usr', $userId)
            ->whereNull('trks_transaksi.trks_tgl_pengembalian')
            ->whereNull('trks_transaksi.deleted_at')
            ->where('trks_transaksi.trks_status', 0)
            ->select(
                'trks_transaksi.trks_tgl_peminjaman',
                'trks_transaksi.trks_tgl_jatuh_tempo',
                'dm_buku.dbuku_judul',
                'trks_transaksi.id_trks',
            )
            ->get()
            ->map(function ($transaksi) {
                // Enkripsi ID buku
                $transaksi->id_trks = Crypt::encryptString($transaksi->id_trks);
                return $transaksi;
            });
        return response()->json($transaksi);
    }


    public function detailBuku(Request $request)
    {
        try {
            $idTrks = Crypt::decryptString($request->id_trks);
            $data['buku'] = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
                ->where('trks_transaksi.id_trks', $idTrks)
                ->whereNull('trks_transaksi.deleted_at')
                ->select('trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_transaksi.id_trks')
                ->first();
            if ($request->trks_tgl_pengembalian > $data['buku']->trks_tgl_jatuh_tempo) {
                $denda = Carbon::parse($data['buku']->trks_tgl_jatuh_tempo)->diffInDays($request->trks_tgl_pengembalian, false);
                $data['denda'] = 2000 * $denda;
            } else {
                $data['denda'] = 0;
            }
            return Response::json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function showEditTransaksi($id)
    {
        $transaksiId = Crypt::decryptString($id);

        $transaksi['transaksi'] = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
            ->where('trks_transaksi.id_trks', $transaksiId)
            ->join('dm_pustakawan', 'trks_transaksi.id_dpustakawan', '=', 'dm_pustakawan.id_dpustakawan')
            ->join('users', 'trks_transaksi.id_usr', '=', 'users.id_usr')
            ->select('trks_transaksi.trks_denda', 'users.id_usr', 'trks_transaksi.trks_tgl_pengembalian', 'trks_transaksi.trks_tgl_peminjaman', 'trks_transaksi.trks_tgl_jatuh_tempo', 'trks_transaksi.trks_tgl_pengembalian', 'dm_buku.dbuku_judul', 'dm_buku.id_dbuku', 'dm_pustakawan.id_dpustakawan', 'dm_pustakawan.dpustakawan_nama', 'users.usr_nama')
            ->first();

        $db['buku'] = dm_buku::select('dm_buku.id_dbuku', 'dm_buku.dbuku_judul')->join('dm_salinan_bukus', 'dm_buku.id_dbuku', '=', 'dm_salinan_bukus.id_dbuku')->groupBy('dm_buku.id_dbuku')->get();
        $db['pustakawan'] = dm_pustakawan::select('dm_pustakawan.id_dpustakawan', 'dm_pustakawan.dpustakawan_nama')->get();
        $db['usr'] = User::select('users.id_usr', 'users.usr_nama')
            ->leftJoin('akses_usrs', 'users.id_usr', '=', 'akses_usrs.id_usr')
            ->whereNull('akses_usrs.id_usr')
            ->whereNull('users.deleted_at')
            ->where('users.usr_stat', 1)
            ->get();

        $options['pustakawan'] = '';
        $options['buku'] = '';
        $options['usr'] = '';

        foreach ($db['buku'] as $buku) {
            $selected = ($buku->id_dbuku == $transaksi['transaksi']->id_dbuku) ? 'selected' : '';
            $options['buku'] .= '<option value="' . Crypt::encryptString($buku->id_dbuku) . '" ' . $selected . '>' . $buku->dbuku_judul . '</option>';
        }
        foreach ($db['pustakawan'] as $pustakawan) {
            $selected = ($pustakawan->id_dpustakawan == $transaksi['transaksi']->id_dpustakawan) ? 'selected' : '';
            $options['pustakawan'] .= '<option value="' . Crypt::encryptString($pustakawan->id_dpustakawan) . '" ' . $selected . '>' . $pustakawan->dpustakawan_nama . '</option>';
        }
        foreach ($db['usr'] as $usr) {
            $selected = ($usr->id_usr == $transaksi['transaksi']->id_usr) ? 'selected' : '';
            $options['usr'] .= '<option value="' . Crypt::encryptString($usr->id_usr) . '" ' . $selected . '>' . $usr->usr_nama . '</option>';
        }


        $transaksi['usr'] = $options['usr'];
        $transaksi['pustakawan'] = $options['pustakawan'];
        $transaksi['buku'] = $options['buku'];

        return response()->json($transaksi);
    }
}
