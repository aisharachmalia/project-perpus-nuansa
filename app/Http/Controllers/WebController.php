<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dm_buku;
use illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    public function berandaPage()
    {
        return view('welcome');
    }

    //
    public function pageLogin()
    {
        if(Auth::check()){
            return redirect()->back();
        }
        
        $login_user = null;

        if (isset($_COOKIE['login_user'])) {
            $cookie = $_COOKIE['login_user'];
            $cookie = \Crypt::decryptString($cookie);
            $login_user = explode('|',$cookie);
        }
        
        return view('auth.login',compact('login_user'));
    }

    //
    public function pageRegister()
    {
        return view('auth.register');
    }

    //
    public function pageForgotPassword()
    {
        return view('auth.forgot');
    }
    public function pageTentang()
    {
        return view('user.tentang');
    }
    
    public function pagePanduan()
    {
        return view('user.panduan');
    }


    public function pageResetPassword($id)
    {
        $id = \Crypt::decryptString($id);
        $user = User::find($id);
        if ($user->kode_otp != null) {
            return view('auth.form_reset_password', compact('user'));
        } else {
            return redirect()->route('forgot_password')->with('otp_null', 'Tidak ada kode otp, kirim kembali email.');
        }
    }
}
