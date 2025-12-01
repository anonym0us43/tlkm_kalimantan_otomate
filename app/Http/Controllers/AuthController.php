<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

date_default_timezone_set('Asia/Jakarta');

class AuthController extends Controller
{
    public static function login()
    {
        return view('auth.login');
    }

    public static function login_post(Request $request)
    {
        $request->validate([
            'nik'      => 'required|numeric',
            'password' => 'required|string',
        ]);

        $user = AuthModel::identity($request->nik);

        if ($user && Hash::check($request->password, $user->password))
        {
            if ($user->is_active == 0)
            {
                return back()->withErrors(['login' => 'User Not Active.']);
            }

            if ($user->is_active == 2)
            {
                return back()->withErrors(['login' => 'Your account is still awaiting activation by the Administrator. Please contact the Administrator for more information.']);
            }

            $remember = $request->has('remember');

            Auth::login($user, $remember);

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

            $profile = AuthModel::profile($user->id);

            Session::put([
                'employee_id'    => $profile->id,
                'regional_id'    => $profile->regional_id,
                'regional_name'  => $profile->regional_name,
                'witel_id'       => $profile->witel_id,
                'witel_name'     => $profile->witel_name,
                'witel_alias'    => $profile->witel_alias,
                'mitra_id'       => $profile->mitra_id,
                'mitra_name'     => $profile->mitra_name,
                'sub_unit_id'    => $profile->sub_unit_id,
                'sub_unit_name'  => $profile->sub_unit_name,
                'sub_group_id'   => $profile->sub_group_id,
                'sub_group_name' => $profile->sub_group_name,
                'role_id'        => $profile->role_id,
                'role_name'      => $profile->role_name,
                'nik'            => $profile->nik,
                'full_name'      => $profile->full_name,
                'chat_id'        => $profile->chat_id,
                'number_phone'   => $profile->number_phone,
                'home_address'   => $profile->home_address,
                'gender'         => $profile->gender,
                'date_of_birth'  => $profile->date_of_birth,
                'place_of_birth' => $profile->place_of_birth,
                'remember_token' => $token,
                'is_logged_in'   => true,
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
}
