<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function updateProfile(Request $request)
    {
        $user = \Auth::User();

        $rules = [
            'usr_nama' => 'required',
            'usr_username' => 'required|unique:users,usr_username,' . $user->id_usr . ',id_usr',
            'usr_email' => 'required|email|unique:users,usr_email,' . $user->id_usr . ',id_usr',
        ];

        if ($request->filled('password')) {
            $rules['password_lama'] = 'required';
            $rules['password'] = [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ];
            $rules['password_konf'] = [
                'required',
                'same:password'
            ];
        }

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
            'password_lama.required' => 'Password lama harus diisi saat mengubah password.',
        ];

        $this->validate($request, $rules, $messages);

        // Check old password only if new password is provided
        if ($request->filled('password') && !\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan tidak cocok.']);
        }

        // Check if new password is the same as the old password
        if ($request->filled('password') && strcmp($request->password_lama, $request->password) == 0) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        $isUpdated = false;

        if ($user->usr_nama !== $request->usr_nama) {
            $user->usr_nama = $request->usr_nama;
            $isUpdated = true;
        }

        if ($user->usr_username !== $request->usr_username) {
            $user->usr_username = $request->usr_username;
            $isUpdated = true;
        }

        if ($user->usr_email !== $request->usr_email) {
            $user->usr_email = $request->usr_email;
            $isUpdated = true;
        }

        if ($request->filled('password')) {
            $user->password = \Hash::make($request->password);
            $isUpdated = true;
        }

        if ($isUpdated) {
            $user->save();
            return redirect()->route('profile')->with('success', 'Profile Berhasil Di Perbarui.');
        }

        // If no updates, redirect without success message
        return redirect()->route('profile');
    }


    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->file('file')) {
            $imagePath = $request->file('file')->store('profile_images', 'public');

            // Assuming you have a 'profile_image' field in your user table
            $user = \Auth::user();
            $user->profile_image = $imagePath;
            $user->save();

            return back()->with('success', 'Profile image updated successfully.');
        }

        return back()->withErrors('Please select an image file to upload.');
    }

}
