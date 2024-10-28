<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dm_salinan_buku;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DmSalinanBukuController extends Controller
{
    public function pageDmSalinanBuku($id = null, Request $request)
    {
        $id = \Crypt::decryptString($id);
        $bk = \DB::select(
            "SELECT dm_buku.*,                                         
                            dm_penulis.dpenulis_nama_penulis, 
                            dm_penerbits.dpenerbit_nama_penerbit
                    FROM dm_buku 
                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                    WHERE dm_buku.id_dbuku = $id; 
        
        "
        );

        return view('data_master.buku.dm_salinan', [
            'id' => $id,
            'bk' => $bk[0],
        ]);
    }

    public function tableDmSalinanBuku(Request $request)
    {
        $id = \Crypt::decryptString($request->id);
        if ($request->ajax()) {
            $salinanBukus = \DB::select(
                    "SELECT * FROM dm_salinan_bukus 
                                    join dm_buku on dm_salinan_bukus.id_dbuku = dm_buku.id_dbuku
                                    WHERE dm_buku.id_dbuku = $id AND dm_salinan_bukus.deleted_at IS NULL;"
            );


            // Return the data for DataTables
            return DataTables::of($salinanBukus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Add action buttons for each record
                    $btn = '<div class="d-flex mr-2 justify-content-center">
                                <a href="javascript:void(0)" data-id="' . \Crypt::encryptString($row->id_dsbuku) . '" class="btn btn-warning btn-sm modalEditSalinan mr-2" data-bs-toggle="modal" data-bs-target="#editSalinan">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                |
                                <a href="javascript:void(0)" id="btn-delete" data-id="' . \Crypt::encryptString($row->id_dsbuku) . '" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function salinanDetail($id = null)
    {
        $id = \Crypt::decryptString($id);
        $dsbk = \DB::select("SELECT dm_salinan_bukus.* FROM dm_salinan_bukus 
                                    WHERE dm_salinan_bukus.id_dsbuku = $id
                            ");
        $kondisi = [
            'Baik' => 'Baik',
            'Rusak' => 'Rusak',
            'Hilang' => 'Hilang',
        ];

        $selectedKondisi = $dsbk[0]->dsbuku_kondisi ?? '';

        $slc1 = '';
        foreach ($kondisi as $kds) {
            $selected = ($kds == $selectedKondisi) ? 'selected' : ''; // Jika kondisi sebelumnya cocok, tambahkan atribut selected
            $slc1 .= '<option value="' . $kds . '" ' . $selected . '>' . $kds . '</option>';
        }

        return response()->json([
            'dsbk' => $dsbk,
            'slc1' => $slc1
        ]);
    }

    public function crudSalinanBuku ($id = null, Request $request){
        try {

            if ($request->isMethod('post') && $id) {
                try {
                    $id_dsbk = \Crypt::decryptString($id);
                
                $rules = [
                    'dsbuku_no_salinan' => 'required|unique:dm_salinan_bukus,dsbuku_no_salinan,' . $id_dsbk . ',id_dsbuku',
                    'dsbuku_kondisi' => 'required',
                ];

                $messages = [
                    'dsbuku_no_salinan.required' => 'No. Salinan harus diisi!',
                    'dsbuku_no_salinan.unique' => 'No. Salinan sudah terdaftar!',
                    'dsbuku_kondisi.required' => 'Kondisi harus diisi!',
                ];

                // Lakukan validasi
                $validator = \Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }

                dm_salinan_buku::where('id_dsbuku', $id_dsbk)->update([
                    'dsbuku_no_salinan' => $request->dsbuku_no_salinan,
                    'dsbuku_kondisi' => $request->dsbuku_kondisi,
                    'dsbuku_status' => 0 ,
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Salinan Buku Berhasil Diubah!',
                ]);

                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan!',
                        'error' => $th->getMessage(),
                    ], 500);
                }
            } else if ($request->isMethod('delete')) {
                try {
                    // Decrypt the salinan ID
                    $idsb = \Crypt::decryptString($id);
            
                    // Find the salinan entry
                    $salinan = dm_salinan_buku::where('id_dsbuku', $idsb)->first();

            
                    if ($salinan) {
                        // Check if dsbuku_flag is 1
                        if ($salinan->dsbuku_flag == 1) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Salinan Buku tidak bisa dihapus Karena Buku sedang di pinjam!',
                            ], 403); // Forbidden
                        }
                
                        // Proceed with deletion
                        $salinan->deleted_at = Carbon::now();
                        $salinan->save();
                
                        // Decrease the total book count in dm_buku
                        \DB::table('dm_buku')
                            ->where('id_dbuku', $salinan->id_dbuku)
                            ->decrement('dbuku_jml_total');
                
                        // Optionally, update the available count if necessary
                        \DB::table('dm_buku')
                            ->where('id_dbuku', $salinan->id_dbuku)
                            ->decrement('dbuku_jml_tersedia');
                
                        return response()->json([
                            'success' => true,
                            'message' => 'Salinan Buku Berhasil Dihapus!',
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Salinan Buku tidak ditemukan!',
                        ], 404);
                    }
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan!',
                        'error' => $th->getMessage(),
                    ], 500);
                }
            } 

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
