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
    public function addPustakawan(Request $request)
    {
        $rules = [
            'dpustakawan_nama' => 'required',
            'dpustakawan_email' => 'required|email|unique:dm_pustakawan,dpustakawan_email',
            'dpustakawan_no_telp' => 'required|unique:dm_pustakawan,dpustakawan_no_telp|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:13',
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
            'dpustakawan_no_telp.min' => 'No. Telepon minimal 11 angka!',
            'dpustakawan_no_telp.max' => 'No. Telepon maksimal 13 angka!',
        ];

        // Lakukan validasi
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $name = ucfirst(strtolower($request->dpustakawan_nama));

        // Check if the name already exists in the users table
        $existingUser = User::where('usr_nama', $name)->first();

        // Generate username, append number if name already exists
        if ($existingUser) {
            $counter = 1;
            // Increment the counter until a unique username is found
            while (User::where('usr_username', $name . $counter)->exists()) {
                $counter++;
            }
            // Create a unique username by appending the counter
            $username = $name . $counter;
        } else {
            // If no user with the same name, use the name as the username
            $username = $name;
        }

        // Create the Pustakawan record
        dm_pustakawan::create([
            'dpustakawan_nama' => $name,
            'dpustakawan_email' => $request->dpustakawan_email,
            'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
            'dpustakawan_alamat' => $request->dpustakawan_alamat,
        ]);

        // Create the User record with hashed password
        $user = User::create([
            'usr_nama' => $name,
            'usr_username' => $username,
            'usr_email' => $request->dpustakawan_email,
            'password' => \Hash::make($request->dpustakawan_no_telp),
        ]);
        $menus = \DB::table('menus')->get();

        foreach ($menus as $menu) {
            for ($i = 1; $i <= 4; $i++) {
                \DB::table('akses_usrs')->insert([
                    'id_usr' => $user->id_usr,
                    'id_role' => 3,
                    'id_menu' => $menu->id_menu,
                    'hak_akses' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
        ], 200);
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
                'dpustakawan_no_telp.required' => 'No. Telepon harus diisi!',
                'dpustakawan_alamat.required' => 'Alamat harus diisi!',
                'dpustakawan_email.unique' => 'Email sudah terdaftar!',
                'dpustakawan_no_telp.unique' => 'No. Telepon sudah terdaftar!',
                'dpustakawan_no_telp.regex' => 'No. Telepon harus angka!',
                'dpustakawan_no_telp.digits_between' => 'No. Telepon harus di antara 11 hingga 13 angka!',
            ];
    
            // Validate request
            $validator = \Validator::make($request->all(), $rules, $messages);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update librarian data
            dm_pustakawan::where('id_dpustakawan', $idPs)->update([
                'dpustakawan_nama' => $request->dpustakawan_nama,
                'dpustakawan_email' => $request->dpustakawan_email,
                'dpustakawan_no_telp' => $request->dpustakawan_no_telp,
                'dpustakawan_alamat' => $request->dpustakawan_alamat,
                'dpustakawan_status' => $request->dpustakawan_status,
            ]);

            $user = User::where('usr_email', $pustakawan->dpustakawan_email)->first();
            $name = ucfirst(strtolower($request->dpustakawan_nama));
            $existingUser = User::where('usr_username', $name)->exists();

            if ($existingUser) {
                $counter = 1;
                // Increment the counter until a unique username is found
                while (User::where('usr_username', $name . $counter)->exists()) {
                    $counter++;
                }
                // Create a unique username by appending the counter
                $username = $name . $counter;
            } else {
                // If no user with the same name, use the name as the username
                $username = $name;
            }

            if ($request->dpustakawan_status == 0) {
                $st = 0;
            } else {
                $st = 0;
            }

            if ($user) {
                // Update only the name and email, keeping the existing username
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

            // Proceed with soft deletion if no transactions are found
            $ps = dm_pustakawan::find($id_dpustakawan);
            $usrps = User::where("usr_username", $ps->dpustakawan_nama)->first();
            $ps->deleted_at = Carbon::now();
            $usrps->deleted_at = Carbon::now();
            $ps->save();
            $usrps->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus!',
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
