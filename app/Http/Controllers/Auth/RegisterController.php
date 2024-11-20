<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function registerUser(Request $request)
    {
        try {
            //Validasi
            $rules = [
                'usr_nama' => 'required',
                'usr_username' => 'required|unique:users',
                'usr_email' => 'required|email|unique:users',
                'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
               'password_konf' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/|same:password',
            ];

            $messages = [
                'usr_nama.required' => 'Nama harus di isi.',
                'usr_username.required' => 'Username harus di isi.',
                'usr_email.required' => 'E-Mail harus di isi.',
                'password.required' => 'Password harus di isi.',
                'password.regex' => 'Password minimal 8 huruf, harus ada huruf besar, kecil, angka dan karakter spesial.',
                'password_konf.required' => 'Konfirmasi Password harus di isi.',
                'usr_email.email' => 'Format E-Mail tidak sesuai.',
                'password_konf.same' => 'Password Konfirmasi harus sama dengan password di atas.',
                'password_konf.regex' => 'Password minimal 8 huruf, harus ada huruf besar, kecil, angka dan karakter spesial.',
                'usr_username.unique' => 'Username ini telah terdaftar.',
                'usr_email.unique' => 'E-Mail ini telah terdaftar.',
            ];

            $this->validate($request, $rules, $messages);

            //Simpan data user baru
            $user = User::create([
                'usr_nama' => $request->usr_nama,
                'usr_username' => $request->usr_username,
                'usr_email' => $request->usr_email,
                'password' => Hash::make($request->password),
            ]);

            // Kirim email verifikasi
            $url = route('verifikasi_user').'/'.Crypt::encryptString($user->id_usr);
            $array = [
                'receive' => $request->usr_email,
                'subject' => 'Verifikasi E-Mail',
                'data' => [
                    'usr_nama' => $request->usr_nama,
                    'url' => $url,
                ],
            ];

            Mail::send('mail.verifikasi',$array, function($message) use($array) {
                $message->to($array['receive'])
                        ->subject($array['subject']);
                $message->from('no-reply@project.com','Project PKL');
            });

            return redirect()->route('login-usr')->with('success', 'Registrasi berhasil!.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
