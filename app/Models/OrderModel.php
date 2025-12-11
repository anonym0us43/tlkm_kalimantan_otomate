<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

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

    public static function planning_post($request)
    {
        $order_id = $request->input('order_id');
        $order_code = $request->input('order_code');

        $existingRecord = DB::table('tb_assign_orders')
            ->where('order_id', $order_id)
            ->orWhere('order_code', $order_code)
            ->first();

        if ($existingRecord)
        {
            $id = $existingRecord->id;

            DB::table('tb_assign_orders')
                ->where('id', $id)
                ->update([
                    'team_id'        => 0,
                    'project_id'     => 0,
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => null,
                    'updated_by'     => session('nik') ?? 0,
                    'updated_at'     => now()
                ]);

            DB::table('tb_report_orders')
                ->where('assign_order_id', $id)
                ->delete();

            DB::table('tb_report_orders')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => null,
                    'coordinates_site' => $request->input('coordinates_site'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            DB::table('tb_report_materials')
                ->where('assign_order_id', $id)
                ->delete();

            if ($request->has('materials'))
            {
                foreach ($request->input('materials') as $material)
                {
                    DB::table('tb_report_materials')
                        ->insert([
                            'assign_order_id'      => $id,
                            'designator_id'        => $material['designator_id'],
                            'qty'                  => $material['qty'],
                            'coordinates_material' => $material['coordinates_material'] ?? null,
                            'created_by'           => session('nik') ?? 0,
                            'created_at'           => now()
                        ]);
                }
            }
        }
        else
        {
            $id = DB::table('tb_assign_orders')
                ->insertGetId([
                    'team_id'        => 0,
                    'project_id'     => 0,
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => null,
                    'created_by'     => session('nik') ?? 0,
                    'created_at'     => now()
                ]);

            DB::table('tb_report_orders')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => null,
                    'coordinates_site' => $request->input('coordinates_site'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            if ($request->has('materials'))
            {
                foreach ($request->input('materials') as $material)
                {
                    DB::table('tb_report_materials')
                        ->insert([
                            'assign_order_id'      => $id,
                            'designator_id'        => $material['designator_id'],
                            'qty'                  => $material['qty'],
                            'coordinates_material' => $material['coordinates_material'] ?? null,
                            'created_by'           => session('nik') ?? 0,
                            'created_at'           => now()
                        ]);
                }
            }
        }

        if ($request->has('photos'))
        {
            $photos = [];
            if (File::exists(public_path('upload/evidence/' . $id)))
            {
                $files = File::files(public_path('upload/evidence/' . $id));
                foreach ($files as $file)
                {
                    $fileName = $file->getFilename();
                    $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                    $parts = explode('_', $nameWithoutExt);
                    if (count($parts) >= 2)
                    {
                        $fileId = end($parts);
                        $photoType = implode('_', array_slice($parts, 0, -1));
                        if ($fileId == $id)
                        {
                            $photos[$photoType] = $file->getPathname();
                        }
                    }
                }
            }
        }
    }
}
