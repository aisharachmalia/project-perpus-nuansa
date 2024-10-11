<?php

namespace App\Http\Controllers;

use App\Models\dm_pustakawan;
use App\Models\Dm_siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $transaksi = Transaksi::join('dm_buku', 'trks_transaksi.id_dbuku', '=', 'dm_buku.id_dbuku')
                ->join('dm_siswas', 'trks_transaksi.id_dsiswa', '=', 'dm_siswas.id_dsiswa')
                ->join('dm_pustakawan', 'trks_transaksi.id_dpustakawan', '=', 'dm_pustakawan.id_dpustakawan')
                ->select('trks_transaksi.*', 'dm_buku.dbuku_judul', 'dm_siswas.dsiswa_nama', 'dm_pustakawan.dpustakawan_nama')
                ->whereNull('trks_transaksi.deleted_at')
                ->get();

            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_trks) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
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
        $buku = \DB::table('dm_buku')->get();
        $siswa = Dm_siswa::all();
        $pustakawan = dm_pustakawan::all();
        return view('transaksi.transaksi', compact('buku', 'siswa', 'pustakawan'));
    }

    // Fungsi untuk create peminjaman
    public function createPeminjaman(Request $request)
    {
        try {
            $request->validate([
                'id_dbuku' => 'required',
                'id_dsiswa' => 'required',
                'id_dpustakawan' => 'required',
                'trks_tgl_peminjaman' => 'required',
                'trks_tgl_jatuh_tempo' => 'required',
            ]);
            $buku = Crypt::decryptString($request->id_dbuku);
            $siswa = Crypt::decryptString($request->id_dsiswa);
            $pustakawan = Crypt::decryptString($request->id_dpustakawan);
            $transaksi = new Transaksi();
            $transaksi->id_dbuku = $buku;
            $transaksi->id_dsiswa = $siswa;
            $transaksi->id_dpustakawan = $pustakawan;
            $transaksi->trks_tgl_peminjaman = $request->trks_tgl_peminjaman;
            $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jatuh_tempo;
            $transaksi->save();

            return response()->json(['message' => 'Data transaksi berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    // Fungsi untuk edit peminjaman
    public function editPeminjaman(Request $request, $id)
    {
        $id_transaksi = Crypt::decryptString($id);

        $rules = [
            'id_dsiswa' => 'required',
            'id_dbuku' => 'required',
            'id_dpustakawan' => 'required',
            'tgl_pinjam' => 'required|date',
        ];

        $messages = [
            'id_dsiswa.required' => 'Siswa harus dipilih!',
            'id_dbuku.required' => 'Buku harus dipilih!',
            'id_dpustakawan.required' => 'Pustakawan harus dipilih!',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        Transaksi::where('id_transaksi', $id_transaksi)->update([
            'id_dsiswa' => $request->id_dsiswa,
            'id_dbuku' => $request->id_dbuku,
            'id_dpustakawan' => $request->id_dpustakawan,
            'tgl_pinjam' => $request->tgl_pinjam,
            'status' => 'Dipinjam',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman Berhasil Diedit!',
        ]);
    }

    // Fungsi untuk create pengembalian
    public function createPengembalian(Request $request, $id)
    {
        $request->validate([
            'id_dbuku' => 'required',
            'id_dsiswa' => 'required',
            'id_dpustakawan' => 'required',
            'trks_tgl_peminjaman' => 'required',
            'trks_tgl_jatuh_tempo' => 'required',
            'trks_tgl_pengembalian' => 'required',
            'trks_denda' => 'required',
            'trks_keterangan' => 'required',
        ]);

        $transaksi = new Transaksi();
        $transaksi->id_dbuku = $request->id_dbuku;
        $transaksi->id_dsiswa = $request->id_dsiswa;
        $transaksi->id_dpustakawan = $request->id_dpustakawan;
        $transaksi->trks_tgl_peminjaman = $request->trks_tgl_peminjaman;
        $transaksi->trks_tgl_jatuh_tempo = $request->trks_tgl_jatuh_tempo;
        $transaksi->trks_tgl_pengembalian = $request->trks_tgl_pengembalian;
        $transaksi->trks_denda = $request->trks_denda;
        $transaksi->trks_keterangan = $request->trks_keterangan;
        $transaksi->save();

        return response()->json(['message' => 'Data pengembalian berhasil disimpan']);
    }

    public function show($id)
    {
        $transaksi = Transaksi::join('dm_buku', 'transaksi.id_dbuku', '=', 'dm_buku.id')
            ->join('dm_siswa', 'transaksi.id_dsiswa', '=', 'dm_siswa.id')
            ->join('dm_pustakawan', 'transaksi.id_dpustakawan', '=', 'dm_pustakawan.id')
            ->select('transaksi.*', 'dm_buku.judul as dbuku_judul', 'dm_siswa.nama as dsiswa_nama', 'dm_pustakawan.nama as dpustakawan_nama')
            ->where('transaksi.id', $id)
            ->first();

        return response()->json($transaksi);
    }

    // Fungsi untuk edit pengembalian
    public function editPengembalian(Request $request, $id)
    {
        $id_transaksi = Crypt::decryptString($id);

        $rules = [
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ];

        $messages = [
            'tgl_kembali.required' => 'Tanggal kembali harus diisi!',
            'tgl_kembali.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal pinjam!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        Transaksi::where('id_transaksi', $id_transaksi)->update([
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'Dikembalikan',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Pengembalian Berhasil Diperbarui!',
        ]);
    }

    public function delete($id)
    {
        $id_trks = Crypt::decryptString($id);
        Transaksi::where('id', $id_trks)->delete();
        return response()->json(['message' => 'Data transaksi berhasil dihapus']);
    }
}
