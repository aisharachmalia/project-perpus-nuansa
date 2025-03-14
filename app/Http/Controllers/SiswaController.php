<?php

namespace App\Http\Controllers;

use App\Models\Dm_siswa;
use App\Models\Transaksi;
use App\Models\Dm_Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exports\SiswaExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
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
        $siswa = DB::table('dm_siswas')
            ->join('dm_kelas', 'dm_siswas.id_dkelas', '=', 'dm_kelas.id_dkelas')
            ->where('dm_siswas.id_dsiswa', $id_dsiswa)
            ->select('dm_siswas.*', 'dm_kelas.dkelas_nama_kelas')
            ->first();
        $kelas = DB::table('dm_kelas')->get();
        $slc = '';
        foreach ($kelas as $mp) {
            $slc .= '<option value="' . $mp->id_dkelas . '" ' . ($mp->id_dkelas == $siswa->id_dkelas ? 'selected' : '') . '>' . $mp->dkelas_nama_kelas . '</option>';
        }

        return response()->json(['siswa' => $siswa, 'slc' => $slc]);
    }

    public function store(Request $request)
{
    try { // Tambahkan try di sini untuk menutupi keseluruhan logic
    
        // Validasi data
        $validator = Validator::make($request->all(), [
            'dsiswa_nama' => 'required',
            'dsiswa_nis' => 'required|numeric|unique:dm_siswas,dsiswa_nis',
            'dsiswa_email' => 'required|email|unique:users,usr_email',  
            'dsiswa_no_telp' => 'required|regex:/^\+?[\d\s\-]+$/|min:10|max:13|unique:dm_siswas,dsiswa_no_telp',
            'dsiswa_alamat' => 'required',
            'id_dkelas' => 'required',
        ], [
            'dsiswa_nama.required' => 'Nama harus diisi!',
            'dsiswa_nis.required' => 'NIS harus diisi!',
            'dsiswa_nis.numeric' => 'NIS harus berupa angka!',
            'dsiswa_nis.unique' => 'NIS Sudah Terdaftar!',
            'dsiswa_email.required' => 'Email harus diisi!',
            'dsiswa_email.email' => 'Format email tidak valid!', 
            'dsiswa_email.unique' => 'Email sudah terdaftar!',
            'dsiswa_no_telp.required' => 'No. Telp harus diisi!',
            'dsiswa_no_telp.regex' => 'No. Telp harus berformat angka yang benar!',
            'dsiswa_no_telp.min' => 'No. Telp minimal 10 angka!',
            'dsiswa_no_telp.max' => 'No. Telp maksimal 13 angka!',
            'dsiswa_no_telp.unique' => 'No. Telp sudah terdaftar!',
            'dsiswa_alamat.required' => 'Alamat harus diisi!',
            'id_dkelas.required' => 'Kelas harus diisi!', 
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }


        $existingSiswa = dm_siswa::where('dsiswa_nama', $request->dsiswa_nama)
                                ->where('dsiswa_nis', $request->dsiswa_nis)
                                ->where('dsiswa_email', $request->dsiswa_email)
                                ->where('dsiswa_no_telp', $request->dsiswa_no_telp)
                                ->where('dsiswa_alamat', $request->dsiswa_alamat)
                                ->first();

        if ($existingSiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa dengan NIS, nama, email, atau no telp yang sama sudah ada!',
            ], 409); 
        }


        $baseUsername =ucfirst(strtolower($request->dsiswa_nama));
        $username = $baseUsername; 
        $counter = 1;

        while (User::where('usr_username', $username)->exists()) {
            $username = $baseUsername .  $counter++;
        }

        // // Proses pembuatan email unik jika sudah ada sebelumnya
        // $baseEmail = $request->dsiswa_email;
        // $email = $baseEmail;
        // $counter = 1;

        // while (User::where('usr_email', $email)->exists()) {
        //     $email = $baseEmail . str_pad($counter, 3, '0', STR_PAD_LEFT);
        //     $counter++;
        // }

        $password = $this->generateRandomPassword();

        $user = User::create([
            'usr_nama' => $request->dsiswa_nama,
            'usr_username' => $username,
            'usr_email' => $request->dsiswa_email,
            'password' => Hash::make($password),
        ]);


        $siswa = dm_siswa::create([
            'id_dkelas' => $request->id_dkelas,
            'dsiswa_nama' => $request->dsiswa_nama,
            'dsiswa_nis' => $request->dsiswa_nis,
            'dsiswa_email' => $request->dsiswa_email,
            'dsiswa_no_telp' => $request->dsiswa_no_telp,
            'dsiswa_alamat' => $request->dsiswa_alamat,
            'id_usr' => $user->id_usr,
            'dsiswa_flag' => 0,
        ]);


        // Buat URL verifikasi
        $url = route('verifikasi_user') . '/' . Crypt::encryptString($user->id_usr);

        // Data untuk email
        $data = [
            'dsiswa_nama' => $siswa->dsiswa_nama,
            'dsiswa_email' => $siswa->dsiswa_email,
            'dsiswa_nis' => $siswa->dsiswa_nis,
            'id_dkelas' => $siswa->dkelas_nama_kelas ?? 'Tidak ada kelas',
            'password' => $password,
            'url' => $url,
        ];

        // Kirim email
        Mail::send('mail.siswa_mail', ['data' => $data], function ($message) use ($siswa) {
            $message->to($siswa->dsiswa_email)
                ->subject('Selamat Bergabung di NuansaBaca!');
            $message->from('no-reply@nuansabaca.com', 'Perpustakaan Nuansa Baca');
        });

        return response()->json([
            'success' => true,
            'message' => 'Data siswa dan pengguna berhasil dibuat!',
        ], 200);

    } catch (\Exception $e) { // Perbaikan catch dan tutup try
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan data atau mengirim email: ' . $e->getMessage(),
        ], 500);
    }
}




private function generateRandomPassword($length = 10)
{
   $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
   return substr(str_shuffle($characters), 0, $length);
}


 
    public function update($id, Request $request)
    {
        try {
            // Dekripsi ID siswa
            $id_dsiswa = Crypt::decryptString($id);
    
            // Validasi data
            $validator = Validator::make($request->all(), [
                'dsiswa_nama' => 'required',
                'dsiswa_nis' => 'required|numeric|unique:dm_siswas,dsiswa_nis,' . $id_dsiswa . ',id_dsiswa',
                'dsiswa_email' => 'required|email|unique:dm_siswas,dsiswa_email,' . $id_dsiswa . ',id_dsiswa',
                'dsiswa_no_telp' => 'required|unique:dm_siswas,dsiswa_no_telp,' . $id_dsiswa . ',id_dsiswa|regex:/^\+?[\d\s\-]+$/|min:10|max:13',
                'dsiswa_alamat' => 'required',
                'id_dkelas' => 'required',
                'dsiswa_sts' => 'required', 
            ], [
                'dsiswa_nama.required' => 'Nama siswa wajib diisi.',
                'dsiswa_nis.required' => 'NIS siswa wajib diisi.',
                'dsiswa_nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
                'dsiswa_nis.numeric' => 'NIS harus berupa angka.',
                'dsiswa_email.required' => 'Email siswa wajib diisi.',
                'dsiswa_email.email' => 'Format email tidak valid.',
                'dsiswa_email.unique' => 'Email sudah digunakan oleh siswa lain.',
                'dsiswa_no_telp.required' => 'Nomor telepon siswa wajib diisi.',
                'dsiswa_no_telp.unique' => 'Nomor telepon sudah digunakan oleh siswa lain.',
                'dsiswa_no_telp.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, dan tanda minus.',
                'dsiswa_no_telp.min' => 'Nomor telepon harus terdiri dari minimal 10 karakter.',
                'dsiswa_no_telp.max' => 'Nomor telepon maksimal 13 karakter.',
                'dsiswa_alamat.required' => 'Alamat siswa wajib diisi.',
                'id_dkelas.required' => 'Kelas wajib dipilih.',
                'dsiswa_sts.required' => 'Status siswa wajib dipilih.',
            ]);
            
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }
    
            $siswa = dm_siswa::findOrFail($id_dsiswa);
            $siswa->update($request->only([
                'dsiswa_nama', 'dsiswa_nis', 'dsiswa_email', 'dsiswa_no_telp', 'dsiswa_alamat', 'id_dkelas', 'dsiswa_sts'
            ]));
    
        
            $user = User::where('usr_email', $siswa->dsiswa_email)->first();
            if ($user) {
                $username = ucfirst(strtolower($request->dsiswa_nama));
                $user->update([
                    'usr_nama' => $request->dsiswa_nama,
                    'usr_email' => $request->dsiswa_email,
                    'usr_stat' => $request->dsiswa_sts, 
                ]);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui!',
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
    try {

        if (is_null($id)) {
            return response()->json([
                'success' => false,
                'message' => 'ID siswa tidak valid!',
            ], 400);
        }


        $id_dsiswa = Crypt::decryptString($id);     

        $siswa = Dm_siswa::find($id_dsiswa);


        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan!',
            ], 404);
        }


        $transaksiCount = Transaksi::where('id_usr', $siswa->id_usr)->count();

        if ($transaksiCount > 0) {
            $siswa->dsiswa_flag = 1;
            $siswa->save();
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini tidak dapat dihapus karena sudah melakukan transaksi!',
            ], 403);
        }


        $user = User::where('id_usr', $siswa->id_usr)->first();
        if ($user) {
            $user->delete();
        }

        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa dan pengguna berhasil dihapus!',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}

    public function linkExportSiswa(Request $request)
    {
        try {
            $link = route('export_siswa');
            return Response::json(array('link' =>$link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportSiswa(Request $request)
    {
        try {
            return (new SiswaExport)->dataExport($request->all())->download('Rekap Siswa.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function linkPrintoutSiswa(Request $request)
    {
        try {
            $link = route('printout_siswa');
            return Response::json(array('link' =>$link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutSiswa(Request $request)
{
    try {
        $siswa = Dm_siswa::all();
        $pdf = Pdf::loadView('pdf.pdf_siswa', compact('siswa'))->setPaper('a4', 'landscape'); 
        return $pdf->stream('Printout Siswa.pdf');
    } catch (\Throwable $th) {
        throw $th;
    }
}

    

// return $pdf->download('Printout Siswa.pdf');
}