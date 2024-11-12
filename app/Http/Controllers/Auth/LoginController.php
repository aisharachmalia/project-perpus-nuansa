<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function loginUser(Request $request)
    {
        try {
            //Validasi
            $rules = [
                'usr_username' => 'required',
                'password' => 'required',
            ];

            $messages = [
                'usr_username.required' => 'Username harus di isi.',
                'password.required' => 'Password harus di isi.',
            ];

            $this->validate($request, $rules, $messages);
            //Cek User
            $username = $request->usr_username;
            $password = $request->password;
            $usr = User::where('usr_username', $username)->first();
            if (!$usr) {
                return redirect()->route('login-usr')->with('error_login3', 'Username tidak terdaftar.');
            } else {
                if ($usr->usr_stat != 1) {
                    return redirect()->route('login-usr')->with('error_login2', 'Akun anda belum di verifikasi.');
                } else {
                    Auth::attempt([
                        'usr_username' => $username,
                        'password' => $password,
                        'usr_stat'  => 1
                    ]);

                    if (Auth::check()) {
                        $menus =  Menu::join('akses_usrs', 'menus.id_menu', '=', 'akses_usrs.id_menu')
                            ->where('akses_usrs.id_usr', Auth::user()->id_usr)
                            ->where('akses_usrs.hak_akses', '>=', 1)
                            ->select('menus.*')
                            ->groupBy('menus.id_menu')
                            ->get();
                        Session::put('menus', $menus);
                        Session::put('redirect_url', $menus[0]->menu_url);

                        if (isset($request->remember_me)) {
                            $user = auth()->user();
                            Auth::login($user, true);

                            $expires = time() + 60 * 60 * 24 * 365;

                            $login_user = Crypt::encryptString($username . '|' . $password);

                            setcookie("login_user", $login_user, $expires);
                        } else {
                            if (isset($_COOKIE['login_user'])) {
                                setcookie("login_user", "", time() - 3600);
                                unset($_COOKIE['login_user']);
                            }
                        }
                        return redirect()->route('home');
                    } else {
                        return redirect()->route('login-usr')->with('error_login', 'Gagal Login.');
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
