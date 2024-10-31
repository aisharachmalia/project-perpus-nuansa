<?php

namespace App\Http\Controllers;

use App\Models\dm_salinan_buku;
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
                    $btn = '
                    <div class="col-md-12 mt-2 d-flex justify-content-center mb-2">
                            <a href="#" class="icon icon-left dropdown" data-bs-toggle="dropdown"><i
                                    class="bi bi-justify fs-3"></i></a>
                            <div class="dropdown-menu justify-content-end">
                                <a href="' . route('pageDmSalinanBuku', Crypt::encryptString($row->id_dbuku)) . '" class="dropdown-item mb-2 text-end">
                                    <span class="badge bg-light-info d-block">Salinan <i class="fas fa-book"></i></span>
                                </a>
                                <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="dropdown-item mb-2 text-end modalEdit" data-bs-toggle="modal" data-bs-target="#edit">
                                    <span class="badge bg-light-primary d-block">Edit <i class="fa fa-pencil"></i></span>
                                </a>
                                <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="dropdown-item mb-2 text-end modalShow" data-bs-toggle="modal" data-bs-target="#show">
                                    <span class="badge bg-light-success d-block">Show <i class="fa fa-eye"></i></span>
                                </a>
                                <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dbuku) . '" class="dropdown-item mb-2 text-end">
                                    <span class="badge bg-light-danger d-block">Delete <i class="fa fa-trash"></i></span>
                                </a>
                            </div>
                        </div>
                    <div class="d-flex mr-2">
                                
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
                    'dbuku_link' => 'nullable',
                    'dbuku_file' => 'mimes:pdf|max:10240',
                    'dbuku_jml_total' => 'required|integer|min:0',
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
                    'dbuku_file.required' => 'File harus diisi!',
                    'dbuku_file.max' => 'File maksimal 10 MB!',
                    'dbuku_file.mimes' => 'File harus berupa PDF!',
                    'dbuku_edisi.required' => 'Edisi harus diisi!',
                    'dbuku_jml_total.required' => 'Jumlah harus diisi!',
                    'dbuku_jml_total.min' => 'Jumlah tidak boleh kurang dari 0!', // Updated message
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

                // Ambil jumlah buku yang sedang dipinjam atau dalam status reservasi
                $borrowedAndReservedCount = dm_salinan_buku::where('id_dbuku', $id_bk->id_dbuku)
                    ->whereIn('dsbuku_status', [1, 2])
                    ->count();


                if ($request->dbuku_jml_total < $borrowedAndReservedCount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah total tidak boleh kurang dari jumlah buku yang sedang dipinjam atau reservasi!',
                    ], 422);
                }


                $oldTotal = $id_bk->dbuku_jml_total;
                $cover = $id_bk->dbuku_cover;

                if ($request->hasFile('dbuku_cover')) {
                    $file = $request->file('dbuku_cover');
                    $cover = 'cover_buku_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/cover', $cover);
                }

                // Ambil file lama
                $file1 = $id_bk->dbuku_file;

                // Jika file baru di-upload
                if ($request->hasFile('dbuku_file')) {
                    $uploadedFile = $request->file('dbuku_file');
                    // Buat nama file baru dengan timestamp
                    $file1 = 'file_buku_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

                    $uploadedFile->storeAs('public/file', $file1);
                }

                // Create the transaction with mapel ID
                $penerbit = Crypt::decryptString($request->id_dpenerbit);
                $penulis = Crypt::decryptString($request->id_dpenulis);

                $jml_tersedia = $id_bk->dbuku_jml_tersedia;

                if ($request->dbuku_jml_total > $oldTotal) {
                    $jml_tersedia += ($request->dbuku_jml_total - $oldTotal);
                } elseif ($request->dbuku_jml_total < $oldTotal) {
                    $jml_tersedia = max(0, $jml_tersedia - ($oldTotal - $request->dbuku_jml_total));
                }

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
                    'dbuku_link' => $request->dbuku_link,
                    'dbuku_file' => $file1,
                    'dbuku_jml_total' => $request->dbuku_jml_total,
                    'dbuku_jml_tersedia' => $jml_tersedia,
                    'dbuku_edisi' => $request->dbuku_edisi,
                    'dbuku_status' => 1,
                    'updated_at' => now(),
                ]);

                if ($request->dbuku_jml_total == 0) {
                    // Delete only "Baik" and "Rusak" copies; keep "Hilang," "Terpinjam," and "Reservasi" intact
                    \DB::table('dm_salinan_bukus')
                        ->where('id_dbuku', $id_bk->id_dbuku)
                        ->whereIn('dsbuku_kondisi', ['Baik', 'Rusak']) // Changed to whereIn
                        ->whereNotIn('dsbuku_status', [1, 2])
                        ->update(['deleted_at' => Carbon::now()]);
                } elseif ($request->dbuku_jml_total > $oldTotal) {
                    $new = $request->dbuku_jml_total - $oldTotal;
                
                    for ($i = 1; $i <= $new; $i++) {
                        $newCopyNumber = $oldTotal + $i;
                        $no_salinan = $request->dbuku_judul . str_pad($newCopyNumber, 5, '0', STR_PAD_LEFT);
                
                        while (dm_salinan_buku::where('dsbuku_no_salinan', $no_salinan)->exists()) {
                            $newCopyNumber++;
                            $no_salinan = $request->dbuku_judul . str_pad($newCopyNumber, 5, '0', STR_PAD_LEFT);
                        }
                        dm_salinan_buku::create([
                            'id_dbuku' => $id_bk->id_dbuku,
                            'dsbuku_no_salinan' => $no_salinan,
                            'dsbuku_kondisi' => 'Baik',
                            'dsbuku_status' => 0,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                } elseif ($request->dbuku_jml_total < $oldTotal) {
                    $excessCopies = $oldTotal - $request->dbuku_jml_total;
                    \DB::table('dm_salinan_bukus')
                        ->where('id_dbuku', $id_bk->id_dbuku)
                        ->whereIn('dsbuku_kondisi', ['Baik', 'Rusak']) // Changed to whereIn
                        ->whereNotIn('dsbuku_status', [1, 2])
                        ->orderBy('created_at', 'desc')
                        ->take($excessCopies)
                        ->update(['deleted_at' => Carbon::now()]);
                }
                
                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                ]);

            } else if ($request->isMethod('post') && !isset($request->id_bk)) {
                $rules = [
                    'dbuku_cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'dbuku_judul' => 'required',
                    'dbuku_isbn' => 'required|unique:dm_buku,dbuku_isbn|numeric|digits:13|min:1',
                    'dbuku_thn_terbit' => 'required',
                    'dbuku_lokasi_rak' => 'required',
                    'dbuku_bahasa' => 'required',
                    'dbuku_link' => 'nullable',
                    'dbuku_file' => 'required|mimes:pdf|max:10240',
                    'dbuku_jml_total' => 'required|integer|min:0',
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
                    'dbuku_file.required' => 'File harus diisi!',
                    'dbuku_file.max' => 'File maksimal 2 MB!',
                    'dbuku_file.mimes' => 'File harus berupa PDF!',
                    'dbuku_edisi.required' => 'Edisi harus diisi!',
                    'dbuku_jml_total.required' => 'Jumlah harus diisi!',
                    'dbuku_jml_total.min' => 'Jumlah tidak boleh kurang dari 0!',
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

                $file = null;
                if (isset($request->dbuku_file)) {
                    $file = $request->dbuku_file;
                    $file = 'file_buku_' . time() . '.' . $file->getClientOriginalExtension();

                    $request->file('dbuku_file')->storeAs(
                        'public/file',
                        $file
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
                    'dbuku_link' => $request->dbuku_link,
                    'dbuku_file' => $file,
                    'dbuku_jml_total' => $request->dbuku_jml_total,
                    'dbuku_jml_tersedia' => $request->dbuku_jml_total,
                    'dbuku_edisi' => $request->dbuku_edisi,
                    'dbuku_status' => 1,
                    'created_at' => Carbon::now(),
                ];

                $newBook = dm_buku::create($buku);

                for ($i = 1; $i <= $request->dbuku_jml_total; $i++) {
                    dm_salinan_buku::create([
                        'id_dbuku' => $newBook->id_dbuku,
                        'dsbuku_no_salinan' => $request->dbuku_judul . str_pad($i, 5, '0', STR_PAD_LEFT),
                        'dsbuku_kondisi' => 'Baik',
                        'dsbuku_status' => 0,
                        'created_at' => Carbon::now(),
                    ]);
                }

                $message = 'Berhasil menyimpan buku';
                $success = true;
                $errors = [];
                $sts_kode = 200;
            } else if ($request->isMethod('delete')) {
                $idb = Crypt::decryptString($id);
                $b = dm_buku::find($idb);

                // Check if the book has any associated records in dm_salinan_buku
                $hasSalinan = dm_salinan_buku::where('id_dbuku', $idb)
                    ->where('deleted_at', null)
                    ->exists();

                if ($hasSalinan) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Buku tidak dapat dihapus karena memiliki salinan!',
                    ], 403);
                }

                // Check if the flag is active
                if ($b->dbuku_flag == 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Buku tidak dapat dihapus karena flag aktif!',
                    ], 403);
                }

                // Proceed with deletion by setting the deleted_at timestamp
                $b->deleted_at = Carbon::now();
                $b->save();

                // Optional: Update fields in dm_salinan_buku if needed
                dm_salinan_buku::where('id_dbuku', $idb)->update([
                    'updated_at' => Carbon::now(),
                    // Tambahkan kolom lain yang ingin diupdate jika diperlukan
                ]);

                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Dihapus!',
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

        $file = '';
        if ($bk[0]->dbuku_file != null) {
            $file = asset('storage/file/' . $bk[0]->dbuku_file);
        } else {
            $file = '';
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
        $selectedThn = $bk[0]->dbuku_thn_terbit ?? '';
        for ($tahun = $tahunMulai; $tahun <= $tahunSekarang; $tahun++) {
            $selected = ($tahun == $selectedThn) ? 'selected' : '';
            $slc5 .= '<option value="' . $tahun . '" ' . $selected . '>' . $tahun . '</option>';
        }

        $bahasa = ["Indonesia", "Inggris", "Mandarin", "Spanyol", "Jepang"];
        $selectedBhs = $bk[0]->dbuku_bahasa ?? '';

        $slc6 = '';
        foreach ($bahasa as $bhs) {
            $selected = ($bhs == $selectedBhs) ? 'selected' : '';
            $slc6 .= '<option value="' . $bhs . '" ' . $selected . '>' . $bhs . '</option>';
        }

        $lokasiRak = ["Rak A", "Rak B", "Rak C", "Rak D", "Rak E"];

        $selectedRak = $bk[0]->dbuku_lokasi_rak ?? '';
        $slc7 = '';
        foreach ($lokasiRak as $rak) {
            $selected = ($rak == $selectedRak) ? 'selected' : '';
            $slc7 .= '<option value="' . $rak . '" ' . $selected . '>' . $rak . '</option>';
        }

        $edisi = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];

        $selectedEdisi = (int) ($bk[0]->dbuku_edisi ?? '');
        $slc8 = '';
        foreach ($edisi as $ed) {
            $selected = ((int) $ed === $selectedEdisi) ? 'selected' : '';
            $slc8 .= '<option value="' . $ed . '" ' . $selected . '>' . $ed . '</option>';
        }



        return response()->json(['bk' => $bk, 'img' => $img, 'file' => $file, 'slc3' => $slc3, 'slc4' => $slc4, 'slc5' => $slc5, 'slc6' => $slc6, 'slc7' => $slc7, 'slc8' => $slc8]);
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
            TCPDF::SetPageOrientation('P');
            TCPDF::AddPage();
            TCPDF::writeHTML($html, true, false, true, false, '');

            return TCPDF::Output($filename, 'I');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cihuyy()
    {
        // if ($request->dbuku_jml_total > $oldTotal) {
        //     $new = $request->dbuku_jml_total - $oldTotal;

        //     for ($i = 1; $i <= $new; $i++) {
        //         // Generate potential dsbuku_no_salinan
        //         $newCopyNumber = $oldTotal + $i;
        //         $no_salinan = $request->dbuku_judul . str_pad($newCopyNumber, 5, '0', STR_PAD_LEFT);

        //         while (dm_salinan_buku::where('dsbuku_no_salinan', $no_salinan)->exists() || $newCopyNumber == 0) {
        //             $newCopyNumber++;
        //             $no_salinan = $request->dbuku_judul . str_pad($newCopyNumber, 5, '0', STR_PAD_LEFT);
        //         }

        //         // If the generated number is 00000, skip this iteration
        //         if ($no_salinan == $request->dbuku_judul . '00000') {
        //             continue;
        //         }

        //         // Create new salinan buku
        //         dm_salinan_buku::create([
        //             'id_dbuku' => $id_bk->id_dbuku,
        //             'dsbuku_no_salinan' => $no_salinan,
        //             'dsbuku_kondisi' => 'Baik',
        //             'dsbuku_status' => 0,
        //             'created_at' => Carbon::now(),
        //         ]);
        //     }
        // }
    }
}