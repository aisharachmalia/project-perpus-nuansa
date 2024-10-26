<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function updateProfile(request $request)
    {        
        $user = \Auth::user();

        // Update user data
        $user->usr_nama = $request->usr_nama;
        $user->usr_username = $request->usr_username;
        $user->usr_email = $request->usr_email;

        $user->save();

    return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
