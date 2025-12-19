<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class OrderModel extends Model
{
    public static function index($id)
    {
        return DB::table('tb_source_tacc_ticket_alita AS tstta')
            ->leftJoin('tb_witel AS tw', 'tstta.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select(
                'tstta.id AS row_id',
                'tstta.tt_site_id',
                'tstta.tt_site',
                'tr.name AS regional_name',
                'tw.name AS witel_name',
                'tstta.start_time AS tiket_start_time',
                'tstta.site_down',
                'tstta.site_name_down',
                'tstta.latitude_site_down',
                'tstta.longitude_site_down',
                'tstta.site_detect',
                'tstta.site_name_detect',
                'tstta.tiket_terima'
            )
            ->where('tstta.id', $id)
            ->first();
    }

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
        $order_id   = $request->input('order_id');
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
                    'team_id'        => $request->input('team_id'),
                    'project_id'     => $request->input('project_id'),
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => $request->input('order_headline'),
                    'updated_by'     => session('nik') ?? 0,
                    'updated_at'     => now()
                ]);

            DB::table('tb_assign_orders_log')
                ->insert([
                    'team_id'        => $request->input('team_id'),
                    'project_id'     => $request->input('project_id'),
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => $request->input('order_headline'),
                    'created_by'     => session('nik') ?? 0,
                    'created_at'     => now()
                ]);

            DB::table('tb_report_orders')
                ->where('assign_order_id', $id)
                ->update([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            DB::table('tb_report_orders_log')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            if ($request->has('materials'))
            {
                DB::table('tb_report_materials')
                    ->where('assign_order_id', $id)
                    ->delete();

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
                    'team_id'        => $request->input('team_id'),
                    'project_id'     => $request->input('project_id'),
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => $request->input('order_headline'),
                    'created_by'     => session('nik') ?? 0,
                    'created_at'     => now()
                ]);

            DB::table('tb_assign_orders_log')
                ->insert([
                    'team_id'        => $request->input('team_id'),
                    'project_id'     => $request->input('project_id'),
                    'order_id'       => $order_id,
                    'order_code'     => $order_code,
                    'order_date'     => now(),
                    'order_headline' => $request->input('order_headline'),
                    'created_by'     => session('nik') ?? 0,
                    'created_at'     => now()
                ]);

            DB::table('tb_report_orders')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            DB::table('tb_report_orders_log')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => 1,
                    'notes'            => $request->input('notes'),
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

        if ($request->hasFile('photos'))
        {
            $uploadPath = public_path('upload/' . $id);

            if (!File::exists($uploadPath))
            {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $photoFile = $request->file('photos');
            if ($photoFile && $photoFile->isValid())
            {
                $fileName = 'Foto_Titik_Putus.jpg';
                $photoFile->move($uploadPath, $fileName);
            }
        }
    }
}
