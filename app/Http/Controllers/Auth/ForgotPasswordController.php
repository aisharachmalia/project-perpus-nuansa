<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function lupaPassword(Request $request)
    {
        try {
            // Validasi
            $rules = [
                'usr_email' => 'required|email',
            ];
    
            $messages = [
                'usr_email.required' => 'E-Mail harus di isi.',
                'usr_email.email' => 'Format E-Mail tidak sesuai.',
            ];
    
            $this->validate($request, $rules, $messages);
    
            // Mencari user dengan email
            $user = User::where('usr_email', $request->usr_email)->first();
    
            // Cek apakah ada email yang terdaftar
            if (!$user) {
                return redirect()->route('forgot_password')->with('error_email', 'Tidak ada email yang sesuai. Silahkan coba lagi.');
            } 
            
            // Jika email belum diverifikasi
            if ($user->email_verified == null) {
                return redirect()->route('forgot_password')->with('error_verifikasi', 'E-Mail belum di verifikasi.');
            }
    
            // Set kode OTP dan simpan
            $user->kode_otp = str()->random(5);
            $user->save();
    
            // Kirim email verifikasi
            $url = route('form_reset_password') . '/' . Crypt::encryptString($user->id_usr);
            $array = [
                'receive' => $request->usr_email,
                'subject' => 'Verifikasi Reset Password',
                'data' => [
                    'usr_email' => $request->usr_email,
                    'usr_nama' => $request->usr_nama,
                    'url' => $url,
                    'kode_otp' => $user->kode_otp
                ],
            ];
    
            Mail::send('mail.reset_password', $array, function ($message) use ($array) {
                $message->to($array['receive'])
                    ->subject($array['subject']);
                $message->from('no-reply@project.com', 'Project PKL');
            });
    
            if (Mail::flushMacros()) {
                \Log::error('Mail failed to send.');
                \Log::info('OTP generated for user: ' . $user->usr_email . ' with OTP: ' . $user->kode_otp);

                return redirect()->route('forgot_password')->with('error_email', 'Gagal mengirim email. Silahkan coba lagi.');
            }
    
            return redirect()->route('forgot_password')->with('success_reset', 'Kami telah mengirimkan email verifikasi ke ' . $request->usr_email);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

    public function storePassword(Request $request)
    {
        try {
            //Validasi
            $rules = [
                'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'kode_otp' => 'required|min:5|max:5',
                'password_konf' => 'required|same:password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ];

            $messages = [
                'password.required' => 'Password harus di isi.',
                'kode_otp.required' => 'Kode OTP harus di isi.',
                'kode_otp.min' => 'Kode OTP tidak boleh kurang dari 5.',
                'kode_otp.max' => 'Kode OTP tidak boleh lebih dari 5.',
                'password_konf.required' => 'Konfirmasi Password harus di isi.',
                'password.regex' => 'Minimal 8 huruf, Harus ada huruf besar, kecil , angka dan karakter spesial.',
                'password_konf.regex' => 'Minimal 8 huruf, Harus ada huruf besar, kecil , angka dan karakter spesial.',
                'password_konf.same' => 'Password Konfirmasi harus sama dengan password di atas.',
            ];

            $this->validate($request, $rules, $messages);

            //Simpan data user baru
            $user = User::where('usr_email',Crypt::decryptString ($request->usr_email))->first();
            if ($user->kode_otp == $request->kode_otp) {
                $user->password = Hash::make($request->password);
                $user->kode_otp = null;
                $user->save();


                // Kirim email verifikasi
                $array = [
                    'receive' => $user->usr_email,
                    'subject' => 'Reset Password Berhasil',
                    'data' => [
                        'usr_email' => $user->usr_email,
                        'usr_nama' => $user->usr_nama,
                        'usr_password' => $request->password,
                    ],
                ];

                Mail::send('mail.reseting_password', $array, function ($message) use ($array) {
                    $message->to($array['receive'])
                        ->subject($array['subject']);
                    $message->from('no-reply@project.com', 'Project PKL');
                });
                if (Mail::flushMacros()) {
                    \Log::error('Mail failed to send.');
                }

                return redirect()->route('login')->with('success_ganti_password', 'Ubah password berhasil.');
            } else {
                return redirect()->back()->with('error_kode_otp', 'Kode OTP tidak sesuai. Silahkan coba lagi.');
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
