<?php

namespace App\Http\Controllers;

use App\Exports\PustakawanExport;
use App\Models\dm_pustakawan;
use App\Models\User;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;


class PustakawanController extends Controller
{
    public function pagePustakawan(Request $request)
    {
        if (request()->ajax()) {
            $pustakawan = \DB::table('dm_pustakawan')->where("deleted_at", null);
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

    private function generateRandomPassword($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        return substr(str_shuffle($characters), 0, $length);
    }

    public function addPustakawan(Request $request)
    {
        $rules = [
            'dpustakawan_nama' => 'required',
            'dpustakawan_email' => 'required|email|unique:users,usr_email',
            'dpustakawan_no_telp' => 'required|unique:dm_pustakawan,dpustakawan_no_telp|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:11,13',
            'dpustakawan_alamat' => 'required',
        ];

        $messages = [
            'dpustakawan_email.email' => 'Format email tidak sesuai',
            'dpustakawan_nama.required' => 'Nama harus diisi!',
            'dpustakawan_email.required' => 'Email harus diisi!',
            'dpustakawan_no_telp.required' => 'No. Telepon harus diisi!',
            'dpustakawan_alamat.required' => 'Alamat harus diisi!',
            'dpustakawan_email.unique' => 'Email sudah terdaftar!',
            'dpustakawan_no_telp.unique' => 'No. Telepon sudah terdaftar!',
            'dpustakawan_no_telp.regex' => 'No. Telepon harus angka!',
            'dpustakawan_no_telp.digits_between' => 'No. Telepon harus antara 11-13 angka!',
        ];

        // Validasi
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $name = ucfirst(strtolower($request->dpustakawan_nama));
        $username = $name;
        $counter = 1;

        while (User::where('usr_username', $username)->exists()) {
            $username = sprintf('%s%d', $name, $counter++);
        }

        $password = $this->generateRandomPassword();

        try {
            // Buat pustakawan
            $pustakawan = dm_pustakawan::create([
                'dpustakawan_nama' => $name,
                'dpustakawan_email' => $request->dpustakawan_email,
                'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
                'dpustakawan_alamat' => $request->dpustakawan_alamat,
            ]);

            $user = User::create([
                'usr_nama' => $name,
                'usr_username' => $username,
                'usr_email' => $request->dpustakawan_email,
                'password' => \Hash::make($password),
            ]);

            $menus = \DB::table('menus')->get();
            $aksesUsrs = $menus->map(function ($menu) use ($user) {
                return [
                    'id_usr' => $user->id_usr,
                    'id_role' => 3,
                    'id_menu' => $menu->id_menu,
                    'hak_akses' => 0,
                    'created_at' => now('Asia/Jakarta'),
                    'updated_at' => now('Asia/Jakarta'),
                ];
            });

            \DB::table('akses_usrs')->insert($aksesUsrs->toArray());

            $url = route('verifikasi_user') . '/' . Crypt::encryptString($user->id_usr);

            \Mail::send('mail.pustakawan_mail', ['data' => $pustakawan, 'password' => $password, 'url' => $url, 'username' => $username], function ($message) use ($pustakawan) {
                $message->to($pustakawan->dpustakawan_email)
                    ->subject('Selamat Bergabung di NuansaBaca!')
                    ->from('no-reply@nuansabaca.com', 'Perpustakaan NuansaBaca');
            });

            return response()->json([
                'success' => true,
                'message' => 'Data Pustakawan berhasil disimpan dan email telah dikirim!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function editPustakawan($id = null, Request $request)
    {
        try {
            $idPs = Crypt::decryptString($id);
            $pustakawan = dm_pustakawan::find($idPs);

            if (!$pustakawan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pustakawan tidak ditemukan',
                ], 404);
            }

            // Cari user berdasarkan email pustakawan sebelumnya
            $user = User::where('usr_email', $pustakawan->dpustakawan_email)->first();

            $rules = [
                'dpustakawan_nama' => 'required',
                'dpustakawan_email' => [
                    'required',
                    'email',
                    Rule::unique('dm_pustakawan', 'dpustakawan_email')
                        ->ignore($pustakawan->id_dpustakawan, 'id_dpustakawan'),
                    Rule::unique('users', 'usr_email')
                        ->ignore($user ? $user->id_usr : null, 'id_usr'),
                ],
                'dpustakawan_no_telp' => 'required|unique:dm_pustakawan,dpustakawan_no_telp,' . $pustakawan->id_dpustakawan . ',id_dpustakawan|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:11,13',
                'dpustakawan_alamat' => 'required',
            ];

            $messages = [
                'dpustakawan_email.email' => 'Format email tidak sesuai',
                'dpustakawan_nama.required' => 'Nama harus diisi!',
                'dpustakawan_email.required' => 'Email harus diisi!',
                'dpustakawan_no_telp.required' => 'No. Telepon harus diisi!',
                'dpustakawan_alamat.required' => 'Alamat harus diisi!',
                'dpustakawan_email.unique' => 'Email sudah terdaftar!',
                'dpustakawan_no_telp.unique' => 'No. Telepon sudah terdaftar!',
                'dpustakawan_no_telp.regex' => 'No. Telepon harus angka!',
                'dpustakawan_no_telp.digits_between' => 'No. Telepon harus di antara 11 hingga 13 angka!',
            ];

            // Validasi request
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update data pustakawan
            dm_pustakawan::where('id_dpustakawan', $idPs)->update([
                'dpustakawan_nama' => $request->dpustakawan_nama,
                'dpustakawan_email' => $request->dpustakawan_email,
                'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
                'dpustakawan_alamat' => $request->dpustakawan_alamat,
                'dpustakawan_status' => $request->dpustakawan_status,
            ]);

            $name = ucfirst(strtolower($request->dpustakawan_nama));
            $existingUser = User::where('usr_username', $name)->exists();

            if ($existingUser) {
                $counter = 1;
                // Tambahkan counter sampai username unik ditemukan
                while (User::where('usr_username', $name . $counter)->exists()) {
                    $counter++;
                }
                $username = $name . $counter;
            } else {
                $username = $name;
            }

            $st = $request->dpustakawan_status == 0 ? 0 : 1;

            if ($user) {
                // Update data user
                $user->update([
                    'usr_username' => $username,
                    'usr_nama' => $request->dpustakawan_nama,
                    'usr_email' => $request->dpustakawan_email,
                    'usr_stat' => $st,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ], 500);
        }
    }




    public function deletePustakawan($id = null)
    {
        try {
            $id_dpustakawan = Crypt::decryptString($id);

            // Check if the pustakawan has lent any books
            $hasTransactions = \DB::table('trks_transaksi')
                ->where('id_dpustakawan', $id_dpustakawan)
                ->exists();

            if ($hasTransactions) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pustakawan tidak dapat dihapus karena pustakawan ini sudah meminjamkan buku.',
                ], 403);
            }

            // Retrieve pustakawan data
            $pustakawan = \DB::table('dm_pustakawan')->where('id_dpustakawan', $id_dpustakawan)->first();
            if (!$pustakawan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pustakawan tidak ditemukan.',
                ], 404);
            }

            // Update pustakawan's deleted_at column
            \DB::table('dm_pustakawan')
                ->where('id_dpustakawan', $id_dpustakawan)
                ->update([
                    'dpustakawan_no_telp' => $pustakawan->dpustakawan_no_telp . '(deleted)',
                    'dpustakawan_email' => $pustakawan->dpustakawan_email . '(deleted)',
                    'dpustakawan_status' => 0,
                    'deleted_at' => Carbon::now('Asia/Jakarta')
                ]);

            // Update the related user record
            \DB::table('users')
                ->where('usr_email', $pustakawan->dpustakawan_email)
                ->update([
                    'usr_username' => $pustakawan->dpustakawan_nama . '(deleted)',
                    'usr_email' => $pustakawan->dpustakawan_email . '(deleted)',
                    'deleted_at' => Carbon::now('Asia/Jakarta'),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Pustakawan dan User terkait berhasil dinonaktifkan.',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ], 500);
        }
    }



    public function linkExportPustakawan(Request $request)
    {
        try {
            $link = route('export_pustakawan');
            return \Response::json(array('link' => $link));
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
    public function linkPrintoutPustakawan(Request $request)
    {
        try {
            $link = route('printout_pustakawan');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutPustakawan(Request $request)
    {
        try {
            $filename = 'pustakawan.pdf';

            $ps = \DB::table('dm_pustakawan')
                ->whereNull('deleted_at') // Only include records that haven't been soft deleted
                ->get();

            $html = \View::make('pdf.pdf_pustakawan', [
                'title' => 'Printout Pustakawan',
                'ps' => $ps,
            ])->render();

            TCPDF::setPrintHeader(false);
            TCPDF::setPrintFooter(false);
            TCPDF::SetPageOrientation('L');
            TCPDF::SetMargins(4, 3, 3, true);

            // $code = 'aisha';

            TCPDF::AddPage();
            // TCPDF::write2DBarcode($code, 'QRCODE,Q', 230, 150, 44, 35, false, 'P');
            TCPDF::writeHTML($html, true, false, true, false, '');

            return TCPDF::Output($filename, 'I');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}