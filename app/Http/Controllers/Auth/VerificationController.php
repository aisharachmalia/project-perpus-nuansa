<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    public function verificationUser($id = null)
    {
        if (!$id) {
            return redirect()->route('login-usr')->with('error_ver', 'Link tidak ditemukan.');
        }

        $id_usr = \Crypt::decryptString($id);
        $user = User::find($id_usr);

        if (!$user) {
            return redirect()->route('login-usr')->with('error_ver', 'Pengguna tidak ditemukan.');
        }
        if (!$user) {
            return redirect()->route('login-usr')->with('error_ver', 'Akun anda belum di verifikasi.');
        }

        if ($user->email_verified) {
            return redirect()->route('login-usr')->with('info_ver', 'Email sudah diverifikasi.');
        }

        $user->email_verified = now('Asia/Jakarta');
        $user->usr_stat = 1;
        $user->save();

        return redirect()->route('login-usr')->with('success_ver', 'Email berhasil diverifikasi.');
    }
}
