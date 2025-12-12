<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\AuthModel;
use App\Models\UserModel;

date_default_timezone_set('Asia/Jakarta');

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'nik'      => 'required|numeric',
            'password' => 'required|string',
            'captcha'  => 'required|captcha',
        ], [
            'captcha.captcha' => 'Incorrect captcha entered.',
        ]);

        $user = AuthModel::identity($request->nik);

        if ($user && Hash::check($request->password, $user->password))
        {
            if ($user->is_active == 0)
            {
                return back()->withErrors(['register' => 'User is not active!']);
            }
            else if ($user->is_active == 3)
            {
                return back()->withErrors(['register' => 'User is suspended!']);
            }

            Auth::login($user);

            $token = Str::random(60);

            $ip_address = null;

            if (isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            elseif (isset($_SERVER['HTTP_X_FORWARDED']))
            {
                $ip_address = $_SERVER['HTTP_X_FORWARDED'];
            }
            elseif (isset($_SERVER['HTTP_FORWARDED_FOR']))
            {
                $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
            }
            elseif (isset($_SERVER['HTTP_FORWARDED']))
            {
                $ip_address = $_SERVER['HTTP_FORWARDED'];
            }
            elseif (isset($_SERVER['REMOTE_ADDR']))
            {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $ip_address = 'UNKNOWN';
            }

            AuthModel::set_token($request->nik, $token, $ip_address);

            $profile = UserModel::profile($user->id);

            Session::put([
                'employee_id'     => $profile->id,
                'regional_id'     => $profile->regional_id,
                'regional_name'   => $profile->regional_name,
                'regional_alias'  => $profile->regional_alias,
                'regional_alias2' => $profile->regional_alias2,
                'witel_id'        => $profile->witel_id,
                'witel_name'      => $profile->witel_name,
                'witel_alias'     => $profile->witel_alias,
                'witel_ alias2'   => $profile->witel_alias2,
                'witel_scope'     => $profile->witel_scope,
                'witel_chat_id'   => $profile->witel_chat_id,
                'witel_thread_id' => $profile->witel_thread_id,
                'partner_id'      => $profile->partner_id,
                'partner_name'    => $profile->partner_name,
                'partner_alias'   => $profile->partner_alias,
                'role_id'         => $profile->role_id,
                'role_name'       => $profile->role_name,
                'nik'             => $profile->nik,
                'first_name'       => $profile->first_name,
                'last_name'       => $profile->last_name,
                'chat_id'         => $profile->chat_id,
                'number_phone'    => $profile->number_phone,
                'home_address'    => $profile->home_address,
                'gender'          => $profile->gender,
                'date_of_birth'   => $profile->date_of_birth,
                'place_of_birth'  => $profile->place_of_birth,
                'remember_token'  => $token,
                'is_logged_in'    => true,
            ]);

            return redirect()->route('home');
        }

        return back()->withErrors(['login' => 'NIK or Password Incorrect!']);
    }

    public function logout()
    {
        Auth::logout();

        Session::flush();

        return redirect()->route('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max: 100',
            'last_name'  => 'nullable|string|max: 100',
            'nik'        => 'required|numeric',
            'chat_id'    => 'nullable|numeric',
            'password'   => 'required|string',
            'captcha'    => 'required|captcha',
        ], [
            'captcha.captcha' => 'Captcha yang dimasukkan salah.',
        ]);

        $user = AuthModel::identity($request->nik);

        if ($user)
        {
            return back()->withErrors(['register' => 'NIK is already registered!']);
        }

        AuthModel::register($request);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
}
