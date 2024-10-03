<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dm_pustakawan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PustakawanExport;

class PustakawanController extends Controller
{
    public function pagePustakawan(Request $request)
    {
        if (request()->ajax()) {
            $pustakawan=\DB::table('dm_pustakawan')->where("deleted_at",null);
            return Datatables::of($pustakawan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpustakawan) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpustakawan) . '" class="btn btn-primary btn-sm modalShow " data-bs-toggle="modal" data-bs-target="#show">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dpustakawan) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('data_master.pustakawan.index');
    }
    public function showPustakawan($id = null)
    {
        $id_dpustakawan = Crypt::decryptString($id);
        $ps = \DB::table('dm_pustakawan')
            ->where('dm_pustakawan.id_dpustakawan', $id_dpustakawan)
            ->first();

       return response()->json($ps);
    }
    public function addPustakawan(Request $request)
    {
        $rules = [
            'dpustakawan_nama' => 'required',
            'dpustakawan_email' => 'required|email|unique:dm_pustakawan,dpustakawan_email',
            'dpustakawan_no_telp' => 'required|unique:dm_pustakawan,dpustakawan_no_telp|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:13',
            'dpustakawan_alamat' => 'required',
        ];

        $messages = [

            'dpustakawan_email.email' => 'Format email tidak sesuai',
            'dpustakawan_nama.required' => 'Nama harus diisi!',
            'dpustakawan_email.required' => 'Email harus diisi!',
            'dpustakawan_no_telp.required' => 'No. Telp harus diisi!',
            'dpustakawan_alamat.required' => 'Alamat harus diisi!',
            'dpustakawan_email.unique' => 'Email sudah terdaftar!',
            'dpustakawan_no_telp.unique' => 'No. Telp sudah terdaftar!',
            'dpustakawan_no_telp.regex' => 'No. Telp harus angka!',
            'dpustakawan_no_telp.min' => 'No. Telp minimal 11 angka!',
            'dpustakawan_no_telp.max' => 'No. Telp maksimal 13 angka!',
        ];

        // Lakukan validasi
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        dm_pustakawan::create([
            'dpustakawan_nama' => $request->dpustakawan_nama,
            'dpustakawan_email' => $request->dpustakawan_email,
            'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
            'dpustakawan_alamat' => $request->dpustakawan_alamat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ], 200);
    }
    
    public function editPustakawan($id = null, Request $request)
    {
        try {
            $idPs = Crypt::decryptString($id);
            $pustakawan = dm_pustakawan::find($idPs);

            $rules = [
                'dpustakawan_nama' => 'required',
                'dpustakawan_email' => 'required|email|unique:dm_pustakawan,dpustakawan_email,' . $pustakawan->id_dpustakawan . ',id_dpustakawan',
                'dpustakawan_no_telp' => 'required|unique:dm_pustakawan,dpustakawan_no_telp,' . $pustakawan->id_dpustakawan . ',id_dpustakawan|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:11,13',
                'dpustakawan_alamat' => 'required',
            ];
            
            $messages = [
                'dpustakawan_email.email' => 'Format email tidak sesuai',
                'dpustakawan_nama.required' => 'Nama harus diisi!',
                'dpustakawan_email.required' => 'Email harus diisi!',
                'dpustakawan_no_telp.required' => 'No. Telp harus diisi!',
                'dpustakawan_alamat.required' => 'Alamat harus diisi!',
                'dpustakawan_email.unique' => 'Email sudah terdaftar!',
                'dpustakawan_no_telp.unique' => 'No. Telp sudah terdaftar!',
                'dpustakawan_no_telp.regex' => 'No. Telp harus angka!',
                'dpustakawan_no_telp.digits_between' => 'No. Telp harus di antara 11 hingga 13 angka!',
            ];
            
            

            // Lakukan validasi
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }


            // Create the transaction with mapel ID
            dm_pustakawan::where('id_dpustakawan', $idPs)->update([
                'dpustakawan_nama' => $request->dpustakawan_nama,
                'dpustakawan_email' => $request->dpustakawan_email,
                'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
                'dpustakawan_alamat' => $request->dpustakawan_alamat,
                'dpustakawan_status' => $request->dpustakawan_status,
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
    public function deletePustakawan($id = null)
    {

        $id_dpustakawan = Crypt::decryptString($id);

        $gr = dm_pustakawan::find($id_dpustakawan);
        $gr->deleted_at = Carbon::now();
        $gr->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
    public function linkExportPustakawan(Request $request)
    {
        try {
            $link = route('export_pustakawan');
            return \Response::json(array('link' =>$link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportPustakawan(Request $request)
    {
        try {
            return (new PustakawanExport)->dataExport($request->all())->download('Rekap Pustakawan.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}


