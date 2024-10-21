<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BukuExport;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\dm_buku;
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
            $buku = \DB::select("SELECT dm_buku.*, 
                                            dm_penulis.dpenulis_nama_penulis, 
                                            dm_penerbits.dpenerbit_nama_penerbit
                                    FROM dm_buku 
                                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                                    WHERE dm_buku.deleted_at IS NULL;
                                ");

            return Datatables::of($buku)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                                <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                |
                                <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="btn btn-primary btn-sm modalShow" data-bs-toggle="modal" data-bs-target="#show">
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
            return response()->json(['error' => 'Failed to load data.'], 500);
        }
    }


    //CRUD
    public function crudBuku(Request $request, $id = null)
    {
        try {
            $success = false;
            $errors = [];
            $sts_kode = 400;


            if ($request->isMethod('post') && isset($request->id_bk)) {
                $id = Crypt::decryptString($id);
                $id_bk = dm_buku::find($id);

                $rules = [
                    'dbuku_cover' => 'image|mimes:jpg,jpeg,png|max:2000',
                    'dbuku_judul' => 'required',
                    'dbuku_isbn' => 'required|unique:dm_buku,dbuku_isbn,' . $id_bk->id_dbuku . ',id_dbuku|numeric|digits:13',
                    'dbuku_thn_terbit' => 'required',
                    'dbuku_lokasi_rak' => 'required',
                    'dbuku_bahasa' => 'required',
                    'dbuku_jml_total' => 'required',
                    'dbuku_edisi' => 'required',
                    'id_dpenulis' => 'required',
                    'id_dpenerbit' => 'required',
                ];

                $messages = [
                    'dbuku_cover.required' => 'Cover Buku harus diisi!',
                    'dbuku_cover.mimes' => 'File harus memiliki format berupa jpg,jpeg,png!',
                    'dbuku_cover.image' => 'File harus berupa gambar!',
                    'dbuku_judul.required' => 'Judul Buku harus diisi!',
                    'dbuku_isbn.required' => 'ISBN harus diisi!',
                    'dbuku_isbn.unique' => 'ISBN sudah terdaftar!',
                    'dbuku_isbn.numeric' => 'ISBN harus berupa angka!',
                    'dbuku_isbn.digits' => 'ISBN harus 13 digit!',
                    'dbuku_thn_terbit.required' => 'Tahun Terbit harus diisi!',
                    'dbuku_lokasi_rak.required' => 'Lokasi Rak harus diisi!',
                    'dbuku_bahasa.required' => 'Bahasa harus diisi!',
                    'dbuku_edisi.required' => 'Edisi harus diisi!',
                    'dbuku_jml_total.required' => 'Jumlah harus diisi!',
                    'id_dpenulis.required' => 'Penulis harus diisi!',
                    'id_dpenerbit.required' => 'Penerbit harus diisi!',
                ];

                // Lakukan validasi
                $validator = \Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }

                $cover = $id_bk->dbuku_cover; // Ambil cover lama

                // Jika file cover baru di-upload
                if ($request->hasFile('dbuku_cover')) {
                    $file = $request->file('dbuku_cover');
                    // Buat nama file baru dengan timestamp
                    $cover = 'cover_buku_' . time() . '.' . $file->getClientOriginalExtension();
                    // Simpan file ke direktori 'public/cover'
                    $file->storeAs('public/cover', $cover);
                }

                // Create the transaction with mapel ID
                $penerbit = Crypt::decryptString($request->id_dpenerbit);
                $penulis = Crypt::decryptString($request->id_dpenulis);

                // Update data
                dm_buku::where('id_dbuku', $id_bk->id_dbuku)->update([
                    'dbuku_cover' => $cover,
                    'dbuku_judul' => $request->dbuku_judul,
                    'dbuku_isbn' => $request->dbuku_isbn,
                    'id_dpenulis' => $penulis,
                    'id_dpenerbit' => $penerbit,
                    'dbuku_thn_terbit' => $request->dbuku_thn_terbit,
                    'dbuku_lokasi_rak' => $request->dbuku_lokasi_rak,
                    'dbuku_bahasa' => $request->dbuku_bahasa,
                    'dbuku_jml_total' => $request->dbuku_jml_total,
                    'dbuku_jml_tersedia' => $request->dbuku_jml_total,
                    'dbuku_edisi' => $request->dbuku_edisi,
                    'dbuku_status' => 1,
                    'updated_at' => now(),
                ]);
                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                ]);
            } else if ($request->isMethod('post') && !isset($request->id_bk)) {
                $rules = [
                    'dbuku_cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'dbuku_judul' => 'required',
                    'dbuku_isbn' => 'required|unique:dm_buku,dbuku_isbn|numeric|digits:13',
                    'dbuku_thn_terbit' => 'required',
                    'dbuku_lokasi_rak' => 'required',
                    'dbuku_bahasa' => 'required',
                    'dbuku_jml_total' => 'required',
                    'dbuku_edisi' => 'required',
                    'id_dpenulis' => 'required',
                    'id_dpenerbit' => 'required',
                ];


                $messages = [
                    'dbuku_cover.required' => 'Cover Buku harus diisi!',
                    'dbuku_cover.mimes' => 'File harus memiliki format berupa jpg,jpeg,png!',
                    'dbuku_cover.image' => 'File harus berupa gambar!',
                    'dbuku_judul.required' => 'Judul Buku harus diisi!',
                    'dbuku_isbn.required' => 'ISBN harus diisi!',
                    'dbuku_isbn.unique' => 'ISBN sudah terdaftar!',
                    'dbuku_isbn.numeric' => 'ISBN harus berupa angka!',
                    'dbuku_isbn.digits' => 'ISBN harus 13 digit!',
                    'dbuku_thn_terbit.required' => 'Tahun Terbit harus diisi!',
                    'dbuku_lokasi_rak.required' => 'Lokasi Rak harus diisi!',
                    'dbuku_bahasa.required' => 'Bahasa harus diisi!',
                    'dbuku_edisi.required' => 'Edisi harus diisi!',
                    'dbuku_jml_total.required' => 'Jumlah harus diisi!',
                    'id_dpenulis.required' => 'Penulis harus diisi!',
                    'id_dpenerbit.required' => 'Penerbit harus diisi!',
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
                    $cover = 'cover_buku_' . time() . '.' . $file->getClientOriginalExtension();

                    $request->file('dbuku_cover')->storeAs(
                        'public/cover',
                        $cover
                    );
                }

                $buku = [
                    'dbuku_cover' => $cover,
                    'dbuku_judul' => $request->dbuku_judul,
                    'dbuku_isbn' => $request->dbuku_isbn,
                    'id_dpenulis' => Crypt::decryptString($request->id_dpenulis),
                    'id_dpenerbit' => Crypt::decryptString($request->id_dpenerbit),
                    'dbuku_thn_terbit' => $request->dbuku_thn_terbit,
                    'dbuku_lokasi_rak' => $request->dbuku_lokasi_rak,
                    'dbuku_bahasa' => $request->dbuku_bahasa,
                    'dbuku_jml_total' => $request->dbuku_jml_total,
                    'dbuku_jml_tersedia' => $request->dbuku_jml_total,
                    'dbuku_edisi' => $request->dbuku_edisi,
                    'dbuku_status' => 1,
                    'created_at' => Carbon::now(),
                ];

                \DB::table('dm_buku')->insert($buku);

                $message = 'Berhasil menyimpan buku';
                $success = true;
                $errors = [];
                $sts_kode = 200;
            } else if ($request->isMethod('delete')) {
                $idb = Crypt::decryptString($id);

                $b = dm_buku::find($idb);
                $b->deleted_at = Carbon::now();
                $b->save();

                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Dihapus!.',
                ]);
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

    public function showBuku($id = null)
    {
        $id_bk = Crypt::decryptString($id);
        $bk = \DB::select("SELECT dm_buku.*,                                         
                                            dm_penulis.dpenulis_nama_penulis, 
                                            dm_penerbits.dpenerbit_nama_penerbit
                                    FROM dm_buku 
                                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                                    WHERE dm_buku.id_dbuku = $id_bk;
                            ");

        $pnls = \DB::select("SELECT * FROM dm_penulis");
        $pnb = \DB::select("SELECT * FROM dm_penerbits");

        $img = '';
        if ($bk[0]->dbuku_cover != null) {
            $img = asset('storage/cover/' . $bk[0]->dbuku_cover);
        } else {
            $img = asset('storage/cover/default.jpg');
        }

        $slc3 = '';
        foreach ($pnb as $key => $value) {
            $slc3 .= '<option value="' . Crypt::encryptString($value->id_dpenerbit) . '" ' . ($value->id_dpenerbit == $bk[0]->id_dpenerbit ? 'selected' : '') . '>' . $value->dpenerbit_nama_penerbit . '</option>';
        }

        $slc4 = '';
        foreach ($pnls as $key => $value) {
            $slc4 .= '<option value="' . Crypt::encryptString($value->id_dpenulis) . '" ' . ($value->id_dpenulis == $bk[0]->id_dpenulis ? 'selected' : '') . '>' . $value->dpenulis_nama_penulis . '</option>';
        }

        $tahunMulai = 2000;
        $tahunSekarang = date("Y");

        $slc5 = '';
        for ($tahun = $tahunMulai; $tahun <= $tahunSekarang; $tahun++) {
            $slc5 .= '<option value="' . $tahun . '">' . $tahun . '</option>';
        }

        $bahasa = ["Indonesia", "Inggris", "Mandarin", "Spanyol", "Jepang"];

        $slc6 = '';
        foreach ($bahasa as $bhs) {
            $slc6 .= '<option value="' . $bhs . '">' . $bhs . '</option>';
        }

        $lokasiRak = ["Rak A", "Rak B", "Rak C", "Rak D", "Rak E"];

        $slc7 = '';
        foreach ($lokasiRak as $rak) {
            $slc7 .= '<option value="' . $rak . '">' . $rak . '</option>';
        }

        $edisi = ["1", "2", "3", "3", "5", "6", "7", "8", "9", "10"];
        $slc8 = '';
        foreach ($edisi as $ed) {
            $slc8 .= '<option value="' . $ed . '">' . $ed . '</option>';
        }


        return response()->json(['bk' => $bk, 'img' => $img, 'slc3' => $slc3, 'slc4' => $slc4, 'slc5' => $slc5, 'slc6' => $slc6, 'slc7' => $slc7, 'slc8' => $slc8]);
    }
    //
    public function linkExportBuku(Request $request)
    {
        try {
            $link = route('export_buku');
            return \Response::json(array('link' => $link));
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

    public function linkPrintoutBuku(Request $request)
    {
        try {
            $link = route('printout_buku');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutBuku(Request $request)
    {
        try {
            $filename = 'Buku.pdf';


            $buku = \DB::select("SELECT dm_buku.*, 
                                                dm_penulis.dpenulis_nama_penulis, 
                                                dm_penerbits.dpenerbit_nama_penerbit
                                        FROM dm_buku 
                                        LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                                        LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                                        WHERE dm_buku.deleted_at IS NULL;
                                    ");

            $html = \View::make('pdf.pdf_buku', [
                'title' => 'Data Buku',
                'buku' => $buku
            ])->render();

            TCPDF::setPrintHeader(false);
            TCPDF::setPrintFooter(false);
            TCPDF::SetPageOrientation('L');
            TCPDF::AddPage();
            TCPDF::writeHTML($html, true, false, true, false, '');

            return TCPDF::Output($filename, 'I');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
