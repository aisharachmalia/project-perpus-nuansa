<?php

namespace App\Http\Controllers;

use App\Models\dm_guru;
use App\Models\dm_mapel;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function pageGuru(Request $request)
    {
        if (request()->ajax()) {
            $gr = dm_guru::join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')->where('dm_gurus.deleted_at', '=', null)->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')->get();
            return Datatables::of($gr)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-primary btn-sm modalShow " data-bs-toggle="modal" data-bs-target="#show">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('data_master.guru.index');
    }

    public function showGuru($id = null)
    {
        $id_dguru = Crypt::decryptString($id);
        $gr = \DB::table('dm_gurus')
            ->join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')
            ->where('dm_gurus.id_dguru', $id_dguru)
            ->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')
            ->first();

        return response()->json($gr);
    }
    public function addGuru(Request $request)
    {
        $rules = [
            'dguru_nama' => 'required',
            'dguru_nip' => 'required|unique:dm_gurus,dguru_nip',
            'dguru_email' => 'required|email|unique:dm_gurus,dguru_email',
            'dguru_no_telp' => 'required|unique:dm_gurus,dguru_no_telp',
            'dguru_alamat' => 'required',
            'id_mapel' => 'required',
        ];

        $messages = [
            'id_mapel.required' => 'Mata Pelajaran harus diisi!',
            'dguru_nama.required' => 'Nama harus diisi!',
            'dguru_nip.required' => 'NIP harus diisi!',
            'dguru_email.required' => 'Email harus diisi!',
            'dguru_no_telp.required' => 'No. Telp harus diisi!',
            'dguru_alamat.required' => 'Alamat harus diisi!',
            'dguru_nip.unique' => 'NIP sudah terdaftar!',
            'dguru_email.unique' => 'Email sudah terdaftar!',
            'dguru_no_telp.unique' => 'No. Telp sudah terdaftar!',
        ];

        // Lakukan validasi
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        dm_guru::create([
            'id_mapel' => $request->id_mapel,
            'dguru_nama' => $request->dguru_nama,
            'dguru_nip' => $request->dguru_nip,
            'dguru_email' => $request->dguru_email,
            'dguru_no_telp' => $request->dguru_no_telp,
            'dguru_alamat' => $request->dguru_alamat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ], 200);
    }


    public function editGuru($id = null, Request $request)
    {
        try {
            $rules = [
                'dguru_nama' => 'required',
                'dguru_nip' => 'required|unique:dm_gurus,dguru_nip',
                'dguru_email' => 'required|email|unique:dm_gurus,dguru_email',
                'dguru_no_telp' => 'required|unique:dm_gurus,dguru_no_telp',
                'dguru_alamat' => 'required',
                'id_mapel' => 'required',
            ];

            $messages = [
                'id_mapel.required' => 'Mata Pelajaran harus diisi!',
                'dguru_nama.required' => 'Nama harus diisi!',
                'dguru_nip.required' => 'NIP harus diisi!',
                'dguru_email.required' => 'Email harus diisi!',
                'dguru_no_telp.required' => 'No. Telp harus diisi!',
                'dguru_alamat.required' => 'Alamat harus diisi!',
                'dguru_nip.unique' => 'NIP sudah terdaftar!',
                'dguru_email.unique' => 'Email sudah terdaftar!',
                'dguru_no_telp.unique' => 'No. Telp sudah terdaftar!',
            ];

            // Lakukan validasi
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $idGr = Crypt::decryptString($id);

            // Create the transaction with mapel ID
            dm_guru::where('id_dguru', $idGr)->update([
                'id_mapel' => $request->id_mapel,
                'dguru_nama' => $request->dguru_nama,
                'dguru_nip' => $request->dguru_nip,
                'dguru_email' => $request->dguru_email,
                'dguru_no_telp' => $request->dguru_no_telp,
                'dguru_alamat' => $request->dguru_alamat,
                'dguru_status' => $request->dguru_status,
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
            ]);

        } catch (\Throwable $th) {
            // Handle exception
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ]);
        }
    }


    public function deleteGuru($id = null)
    {

        $id_dguru = Crypt::decryptString($id);

        $gr = dm_guru::find($id_dguru);
        $gr->deleted_at = Carbon::now();
        $gr->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
}
