<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    public function profile_post($id, Request $request)
    {
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
