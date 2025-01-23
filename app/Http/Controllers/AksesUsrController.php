<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
 
class AksesUsrController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query()->whereNull("deleted_at")->where("id_usr", ">=", 2)->select("id_usr", "usr_username", "usr_email", "usr_nama", "usr_stat")->get();
            return DataTables::of($users)->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = "";
                    $role = User::join('akses_usrs', 'akses_usrs.id_usr', 'users.id_usr')
                        ->where('users.id_usr', $row->id_usr)
                        ->where('akses_usrs.id_role', '<=', 2)
                        ->first();
                    $roleAusr = User::leftJoin(
                        'akses_usrs',
                        'akses_usrs.id_usr',
                        'users.id_usr',
                    )
                        ->where('users.id_usr', $row->id_usr)
                        ->where(function ($query) {
                            $query
                                ->whereIn('akses_usrs.id_role', [1, 2])
                                ->orWhereNull('akses_usrs.id_usr');
                        })
                        ->first();
                    if (!$roleAusr)
                        $btn .= ' <a href="javascript:void(0)" class="btn btn-success btn-sm modalAkses my-1"
                            data-bs-toggle="modal" data-bs-target="#akses"
                            data-id="' . Crypt::encryptString($row->id_usr) . '">Akses</a>&nbsp;';
                    if (!$role)
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm defaultPassword"
                            data-bs-toggle="modal" data-bs-target="#reset"
                            data-id="' . Crypt::encryptString($row->id_usr) . '">Reset
                            Password</a>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('setting.akses-users.index');
    }

    public function detail(Request $request, $id = null)
    {
        if ($request->type == "akses") {
            $id_usr = Crypt::decryptString($id);
            $user = DB::table('users')
                ->join('akses_usrs', 'akses_usrs.id_usr', '=', 'users.id_usr')
                ->groupBy('users.id_usr', 'akses_usrs.id_role')
                ->where('users.id_usr', $id_usr)
                ->select('users.id_usr', 'akses_usrs.id_role', 'users.usr_username', 'users.usr_email', 'users.usr_nama')
                ->get();
            $data['user'] = $user;
            $menu = DB::table('menus')->get();
            $mn = '';
            foreach ($menu as $key => $value) {
                $ausr = DB::select("SELECT * FROM akses_usrs WHERE id_usr=$id_usr ANd deleted_at is null ANd id_menu=$value->id_menu ");
                $c = '';
                if (count($ausr) > 0) {
                    foreach ($ausr as $ky => $val) {
                        $n = 1 + $ky;
                        $c .= '<td> <input class="form-check-input" type="checkbox" value="' . $n . '" id="defaultCheck' . $n . '" name="akses[' . $val->id_akses . ']" ' . ($val->hak_akses == $n ? 'checked' : '') . '></td>';
                    }
                }
                $mn .= '
                    <tr class="text-center">
                        <td scope="row">' . $value->menu_nama . '</td>
                        ' . $c . '
                    </tr>';
            }

            $data['akses'] = '<div class="table-responsive">
                                <table class="p-4 table table-borderless">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Akses Menu</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Full Access</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ' . $mn . '
                                    </tbody>
                                </table>
                            </div>';
            return response($data);
        } else {
            $id_usr = Crypt::decryptString($id);
            $user = DB::table('users')->where('users.id_usr', $id_usr)
                ->select('users.id_usr', 'users.usr_username', 'users.usr_email', 'users.usr_nama')
                ->get();
            $data['user'] = $user;
            $data['password'] = 'Default@0' . str()->random(3);
            return response($data);
        }
    }
    public function store(Request $request)
    {
        try {
            //id_usr
            $id_usr = Crypt::decryptString($request->id_usr);

            //mengupdate semua akses user menjadi 0, berdasarkan id_usr
            DB::update("UPDATE akses_usrs SET hak_akses=0  WHERE id_usr=$id_usr AND deleted_at is null");

            //cek jika ada request akses
            if (isset($request->akses)) {
                //Foreach data request
                foreach ($request->akses as $key => $value) {
                    //update data tabel akses user ,di mana id_akses = $key
                    //dan yang di update itu hak_akses berdasarkan request
                    DB::update("UPDATE akses_usrs SET hak_akses=$value WHERE id_akses=$key");
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Akses User Brhasil Diperbaharui!.',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function defaultPassword($id = null, Request $request)
    {
        try {
            $id_usr = Crypt::decryptString($id);
            $user = User::find($id_usr);
            if ($user->usr_stat == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ini belum di verifikasi!'
                ]);
            }
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            $array = [
                'receive' => $user->usr_email,
                'subject' => 'Default pasword anda',
                'data' => [
                    'usr_nama' => $user->usr_nama,
                    'usr_password' => $request->password,
                ],
            ];

            Mail::send('mail.reseting_password', $array, function ($message) use ($array) {
                $message->to($array['receive'])
                    ->subject($array['subject']);
                $message->from('no-reply@project.com', 'Project PKL');
            });
            return response()->json([
                'success' => true,
                'message' => 'Password Default telah dikirimkan ke user melalui E-Mail!'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
