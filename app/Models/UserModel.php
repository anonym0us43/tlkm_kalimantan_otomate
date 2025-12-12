<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

date_default_timezone_set('Asia/Jakarta');

class UserModel extends Model
{
    public static function profile($id)
    {
        return DB::table('tb_employee AS te')
            ->leftJoin('tb_regional AS tr', 'te.regional_id', '=', 'tr.id')
            ->leftJoin('tb_witel AS tw', 'te.witel_id', '=', 'tw.id')
            ->leftJoin('tb_partner AS tp', 'te.partner_id', '=', 'tp.id')
            ->leftJoin('tb_roles AS trl', 'te.role_id', '=', 'trl.id')
            ->select(
                'te.*',
                'tr.name AS regional_name',
                'tr.alias AS regional_alias',
                'tr.alias2 AS regional_alias2',
                'tw.name AS witel_name',
                'tw.alias AS witel_alias',
                'tw.alias2 AS witel_alias2',
                'tw.scope AS witel_scope',
                'tw.chat_id AS witel_chat_id',
                'tw.thread_id AS witel_thread_id',
                'tp.name AS partner_name',
                'tp.alias AS partner_alias',
                'trl.name AS role_name'
            )
            ->where([
                ['te.id', '=', $id]
            ])
            ->first();
    }

    public static function profile_post(Request $request)
    {
        return DB::table('tb_employee')
            ->where('id', $request->input('id'))
            ->update([
                'first_name'      => $request->input('first_name'),
                'last_name'      => $request->input('last_name'),
                'nik'            => $request->input('nik'),
                'chat_id'        => $request->input('chat_id'),
                'gender'         => $request->input('gender'),
                'number_phone'   => $request->input('number_phone'),
                'date_of_birth'  => $request->input('date_of_birth'),
                'place_of_birth' => $request->input('place_of_birth'),
                'home_address'   => $request->input('home_address'),
                'regional_id'    => $request->input('regional_id'),
                'witel_id'       => $request->input('witel_id'),
                'partner_id'     => $request->input('partner_id')
            ]);
    }
}
