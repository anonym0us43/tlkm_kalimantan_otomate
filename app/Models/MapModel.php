<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class MapModel extends Model
{
    public static function get_all_sites()
    {
        return DB::table('tb_source_diginav_mtel')
            ->select(
                'ring_id',
                'regional',
                'witel',
                'site_ne',
                'site_name_ne',
                'site_owner_ne',
                'site_lat_ne',
                'site_long_ne',
                'site_fe',
                'site_name_fe',
                'site_owner_fe',
                'site_lat_fe',
                'site_long_fe'
            )
            ->get();
    }

    public static function get_site_by_id($site_id)
    {
        return DB::table('tb_source_diginav_mtel')
            ->select(
                'ring_id',
                'regional',
                'witel',
                'site_ne',
                'site_name_ne',
                'site_owner_ne',
                'site_lat_ne',
                'site_long_ne',
                'site_fe',
                'site_name_fe',
                'site_owner_fe',
                'site_lat_fe',
                'site_long_fe'
            )
            ->where('site_ne', $site_id)
            ->first();
    }
}
