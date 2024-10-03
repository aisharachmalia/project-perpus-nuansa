<?php

namespace App\Http\Controllers;

use App\Models\Dm_siswa;
use App\Models\Dm_Kelas;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $siswa = dm_siswa::join('dm_kelas', 'dm_kelas.id_dkelas', '=', 'dm_siswas.id_dkelas')->where('dm_siswas.deleted_at', '=', null)->select('dm_siswas.*', 'dm_kelas.dkelas_nama_kelas')->get();
            // $siswa = \DB::select('SELECT dm_siswas.*, dm_kelas.dkelas_nama_kelas
            //                         FROM dm_siswas
            //                         JOIN dm_kelas ON dm_kelas.id_dkelas =dm_siswas.id_dkelas');

            return Datatables::of($siswa)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dsiswa) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dsiswa) . '" class="btn btn-primary btn-sm modalShow " data-bs-toggle="modal" data-bs-target="#show">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dsiswa) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('dmsiswa.index');
    }

    public function show($id = null)
    {
        $id_dsiswa = Crypt::decryptString($id);
        $siswa = \DB::table('dm_siswas')
            ->join('dm_kelas', 'dm_siswas.id_dkelas', '=', 'dm_kelas.id_dkelas')
            ->where('dm_siswas.id_dsiswa', $id_dsiswa)
            ->select('dm_siswas.*', 'dm_kelas.dkelas_nama_kelas')
            ->first();
        $kelas = \DB::table('dm_kelas')->get();
        $slc = '';
        foreach ($kelas as $mp) {
            $slc .= '<option value="' . $mp->id_dkelas . '" ' . ($mp->id_dkelas == $siswa->id_dkelas ? 'selected' : '') . '>' . $mp->dkelas_nama_kelas . '</option>';
        }

        return response()->json(['siswa' => $siswa, 'slc' => $slc]);
    }
    public function store(Request $request)
{
    $rules = [
        'dsiswa_nama' => 'required',
        'dsiswa_nis' => 'required|unique:dm_siswas,dsiswa_nis',
        'dsiswa_email' => 'required|email|unique:dm_siswas,dsiswa_email',
        'dsiswa_no_telp' => 'required|unique:dm_siswas,dsiswa_no_telp|regex:/^\+?[\d\s\-]+$/|min:10|max:13',
        'dsiswa_alamat' => 'required',
        'id_dkelas' => 'required',
    ];

    $messages = [
        'dsiswa_email.email' => 'Format email tidak sesuai',
        'dsiswa_email.required' => 'Email harus diisi!',
        'dsiswa_email.unique' => 'Email sudah terdaftar!',
        'id_dkelas.required' => 'Kelas harus diisi!',
        'dsiswa_nama.required' => 'Nama harus diisi!',
        'dsiswa_nis.required' => 'NIS harus diisi!',
        'dsiswa_no_telp.required' => 'No. Telp harus diisi!',
        'dsiswa_alamat.required' => 'Alamat harus diisi!',
        'dsiswa_nis.unique' => 'NIS sudah terdaftar!',
        'dsiswa_email.unique' => 'Email sudah terdaftar!',
        'dsiswa_no_telp.unique' => 'No. Telp sudah terdaftar!',
        'dsiswa_no_telp.regex' => 'No. Telp harus berformat angka yang benar!',
        'dsiswa_no_telp.min' => 'No. Telp minimal 10 angka!',
        'dsiswa_no_telp.max' => 'No. Telp maksimal 13 angka!',
    ];

    // Lakukan validasi
    $validator = \Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    dm_siswa::create([
        'id_dkelas' => $request->id_dkelas,
        'dsiswa_nama' => $request->dsiswa_nama,
        'dsiswa_nis' => $request->dsiswa_nis,
        'dsiswa_email' => $request->dsiswa_email,
        'dsiswa_no_telp' => $request->dsiswa_no_telp,
        'dsiswa_alamat' => $request->dsiswa_alamat,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data Berhasil Disimpan!',
    ], 200);
}

public function update($id = null, Request $request)
{
    try {
        // Decrypt ID siswa
        $id_dsiswa = Crypt::decryptString($id);
        
        // Rules untuk validasi
        $rules = [
            'dsiswa_nama' => 'required',
            'dsiswa_nis' => 'required|unique:dm_siswas,dsiswa_nis,' . $id_dsiswa . ',id_dsiswa',
            'dsiswa_email' => 'required|email|unique:dm_siswas,dsiswa_email,' . $id_dsiswa . ',id_dsiswa',
            'dsiswa_no_telp' => 'required|unique:dm_siswas,dsiswa_no_telp,' . $id_dsiswa . ',id_dsiswa|regex:/^\+?[\d\s\-]+$/|min:10|max:13',
            'dsiswa_alamat' => 'required',
            'id_dkelas' => 'required',
        ];

        // Pesan validasi
        $messages = [
            'id_dkelas.required' => 'Kelas harus diisi!',
            'dsiswa_nama.required' => 'Nama harus diisi!',
            'dsiswa_nis.required' => 'NIS harus diisi!',
            'dsiswa_email.required' => 'Email harus diisi!',
            'dsiswa_email.email' => 'Format email tidak sesuai!',
            'dsiswa_no_telp.required' => 'No. Telp harus diisi!',
            'dsiswa_alamat.required' => 'Alamat harus diisi!',
            'dsiswa_nis.unique' => 'NIS sudah terdaftar!',
            'dsiswa_email.unique' => 'Email sudah terdaftar!',
            'dsiswa_no_telp.unique' => 'No. Telp sudah terdaftar!',
            'dsiswa_no_telp.regex' => 'No. Telp harus berformat angka yang benar!',
        ];

        // Lakukan validasi
        $validator = \Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data siswa
        dm_siswa::where('id_dsiswa', $id_dsiswa)->update([
            'dsiswa_nama' => $request->dsiswa_nama,
            'dsiswa_nis' => $request->dsiswa_nis,
            'dsiswa_email' => $request->dsiswa_email,
            'dsiswa_no_telp' => $request->dsiswa_no_telp,
            'dsiswa_alamat' => $request->dsiswa_alamat,
            'id_dkelas' => $request->id_dkelas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
        ]);
    }
}



    public function destroy($id = null)
    {

        $id_dsiswa = Crypt::decryptString($id);
        $siswa = dm_siswa::find($id_dsiswa);
        
        $siswa->deleted_at = Carbon::now();
        $siswa->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
}
