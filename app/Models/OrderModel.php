<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    public static function get_ticket_alita_detail($id)
    {
        $data = DB::table('tb_source_tacc_ticket_alita_detail')
            ->where('id', $id)
            ->get();

        $response[] = [];

        if (!$data->isEmpty())
        {
            foreach ($data as $key => $value)
            {
                $keywords = ['Upload evidence berangkat:', 'Upload evidence di site:', 'Evidence pengukuran:', 'Evidence RCA:', 'Evidence perbaikan:', 'link up'];

                foreach ($keywords as $word)
                {
                    if (stripos($value->info, $word) !== false)
                    {
                        $format = str_replace('https://mtel.tacc.id/storage/bot_file/', '', trim($value->attachment));

                        $response[] = 'https://superbot.warriors.id/bot_lensa_task/Download/evidence/' . $format;

                        break;
                    }
                }
            }
        }

        return $response;
    }
}
