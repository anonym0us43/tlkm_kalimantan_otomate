<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

date_default_timezone_set('Asia/Jakarta');

class AuthModel extends Authenticatable
{
    protected $table = 'tb_employee';

    protected $fillable = [
        'regional_id',
        'witel_id',
        'partner_id',
        'role_id',
        'nik',
        'first_name',
        'last_name',
        'chat_id',
        'number_phone',
        'home_address',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'remember_token',
        'google2fa_secret',
        'password',
        'ip_address',
        'log_latitude',
        'log_longitude',
        'log_otp_telegram',
        'log_otp_telegram_expired',
        'log_otp_google2fa',
        'is_active',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'login_at'
    ];

    protected $hidden = [
        'remember_token',
        'google2fa_secret',
        'password',
    ];

    public static function identity($nik)
    {
        return self::where('nik', $nik)->first();
    }

    public static function set_token($nik, $token, $ip_address)
    {
        $user = self::where('nik', $nik)->first();

        if (! $user)
        {
            return false;
        }

        $user->update([
            'remember_token' => $token,
            'ip_address'     => $ip_address,
            'login_at'       => now(),
        ]);

        return true;
    }

    public function role()
    {
        return $this->belongsTo(RolesModel::class, 'role_id');
    }

    public static function register($request)
    {
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

        self::create([
            'first_name'      => $request->first_name,
            'last_name'      => $request->last_name,
            'nik'            => $request->nik,
            'chat_id'        => $request->chat_id,
            'password'       => Hash::make($request->password),
            'ip_address'     => $ip_address,
            'remember_token' => $token,
            'is_active'      => 2,
            'created_at'     => now(),
        ]);
    }
}
