<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BukuExport;
class BukuController extends Controller
{
    //Halaman
    public function pageBuku()
    {
        return view('data_master.buku.index');
    }

    //Tabel
    public function tableBuku(Request $request)
    {
        try {
            $buku = \DB::select("SELECT id_dbuku,dbuku_judul,dbuku_isbn,dbuku_status
                                FROM dm_buku as db
                                WHERE deleted_at is null");
            return Datatables::of($buku)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="btn btn-primary btn-sm modalShow " data-bs-toggle="modal" data-bs-target="#show">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //CRUD
    public function crudBuku(Request $request)
    {
        try {
            $success = false;
            $errors = [];
            $sts_kode = 400;

            if ($request->isMethod('post')) {
                $rules = [
                    'dbuku_judul' => 'required',
                    'dbuku_isbn' => 'required|unique:dm_buku,dbuku_isbn',
                    'dbuku_thn_terbit' => 'required',
                    'dbuku_lokasi_rak' => 'required',
                    'dbuku_bahasa' => 'required',
                    'dbuku_jml_total' => 'required',
                    'id_dpenulis' => 'required',
                    'id_dpenerbit' => 'required',
                    'id_dkategori' => 'required',
                    'id_dmapel' => 'required',
                ];
        
                $messages = [
                    'dbuku_judul.required' => 'Judul Buku harus diisi!',
                    'dbuku_isbn.required' => 'ISBN harus diisi!',
                    'dbuku_isbn.unique' => 'ISBN sudah terdaftar!',
                    'dbuku_thn_terbit.required' => 'Tahun Terbit harus diisi!',
                    'dbuku_lokasi_rak.required' => 'Lokasi Rak harus diisi!',
                    'dbuku_bahasa.required' => 'Bahasa harus diisi!',
                    'dbuku_jml_total.required' => 'Jumlah harus diisi!',
                    'id_dpenulis.required' => 'Penulis harus diisi!',
                    'id_dpenerbit.required' => 'Penerbit harus diisi!',
                    'id_dkategori.required' => 'Kategori harus diisi!',
                    'id_dmapel.required' => 'Mata Pelajaran harus diisi!',
                ];
        
                // Lakukan validasi
                $validator = \Validator::make($request->all(), $rules, $messages);
        
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menyimpan data Buku',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $cover = null;
                if (isset($request->dbuku_cover)) {
                    $file = $request->dbuku_cover;
                    $cover = 'cover_buku_'.time().'.'.$file->getClientOriginalExtension();
                    
                    $request->file('dbuku_cover')->storeAs(
                        'public/cover', $cover
                    );
                }

                $buku = [
                    'dbuku_cover' => $cover,
                    'dbuku_judul' => $request->dbuku_judul,
                    'dbuku_isbn' => $request->dbuku_isbn,
                    'id_dpenulis' => 1,
                    'id_dpenerbit' => 1,
                    'id_dkategori' => 1,
                    'id_dmapel' => 1,
                    'dbuku_thn_terbit' => $request->dbuku_thn_terbit,
                    'dbuku_lokasi_rak' => $request->dbuku_lokasi_rak,
                    'dbuku_bahasa' => $request->dbuku_bahasa,
                    'dbuku_jml_total' => $request->dbuku_jml_total,
                    'dbuku_jml_tersedia' => $request->dbuku_jml_total,
                    'dbuku_edisi' => 1,
                    'dbuku_status' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];

                \DB::table('dm_buku')->insert($buku);

                $message = 'Berhasil menyimpan buku';
                $success = true;
                $errors = [];
                $sts_kode = 200;
            }

            if ($request->isMethod('put')) {
                $message = 'Gagal merubah data buku';
                
            }

            if ($request->isMethod('delete')) {
                $message = 'Gagal menghapus data buku';
               
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'errors' => $errors,
            ], $sts_kode);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //
    public function linkExportBuku(Request $request)
    {
        try {
            $link = route('export_buku');
            return \Response::json(array('link' =>$link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportBuku(Request $request)
    {
        try {
            return (new BukuExport)->dataExport($request->all())->download('Rekap Buku.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
