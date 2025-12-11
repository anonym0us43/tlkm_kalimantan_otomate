<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class SettingModel extends Model
{
    public static function get_designator()
    {
        return DB::table('tb_designator_khs')
            ->select(
                'id',
                'item_designator',
                'item_description',
                'unit',
                'package_id',
                'material_price_mitra',
                'service_price_mitra',
                'material_price_mtel',
                'service_price_mtel'
            )
            ->get();
    }
}
