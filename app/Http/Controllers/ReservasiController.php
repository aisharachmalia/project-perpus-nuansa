<?php

namespace App\Http\Controllers;

use App\Models\trks_reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ReservasiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $reservasi = trks_reservasi::join('dm_buku', 'dm_buku.id_dbuku', '=', 'trks_reservasi.id_dbuku')->join('users', 'users.id_usr', '=', 'trks_reservasi.id_usr')->select('users.usr_nama','dm_buku.dbuku_judul','trks_reservasi.trsv_tgl_reservasi','trks_reservasi.trsv_tgl_kadaluarsa','trks_reservasi.trsv_tgl_pemberitahuan','trks_reservasi.trsv_tgl_pengembalian','trks_reservasi.trsv_status')->whereNull('trks_reservasi.deleted_at')->get();

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
}
