<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AksesUsrController extends Controller
{
    public function index()
    {
        $usr = User::whereNull('deleted_at')->get();
        return view('setting.akses-users.index', compact('usr'));
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
            $data['password'] = str()->random(8);
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
