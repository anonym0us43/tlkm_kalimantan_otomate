<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class OrderModel extends Model
{
    private static function normalizeCoordinatesInput($value)
    {
        if (is_array($value))
        {
            $normalized = array_values(array_filter(array_map('trim', $value), fn($val) => $val !== ''));

            return !empty($normalized) ? json_encode($normalized) : null;
        }

        if (is_string($value))
        {
            $trimmed = trim($value);

            return $trimmed !== '' ? $trimmed : null;
        }

        return null;
    }

    private static function decodeCoordinatesValue($value)
    {
        if (empty($value))
        {
            return [];
        }

        if (is_array($value))
        {
            return array_values(array_filter(array_map('trim', $value), fn($val) => $val !== ''));
        }

        if (is_string($value))
        {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
            {
                return array_values(array_filter(array_map('trim', $decoded), fn($val) => $val !== ''));
            }

            return array_values(array_filter(array_map('trim', preg_split('/[\r\n;]+/', $value)), fn($val) => $val !== ''));
        }

        return [];
    }

    public static function index($id)
    {
        return DB::table('tb_source_tacc_ticket_alita AS tstta')
            ->leftJoin('tb_assign_orders AS tao', 'tstta.tt_site_id', '=', 'tao.order_id')
            ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
            ->leftJoin('tb_witel AS tw', 'tstta.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select(
                'tstta.id AS row_id',
                'tstta.tt_site_id',
                'tstta.tt_site',
                'tr.name AS regional_name',
                'tw.name AS witel_name',
                'tstta.created_at',
                'tstta.site_down',
                'tstta.site_name_down',
                'tstta.latitude_site_down',
                'tstta.longitude_site_down',
                'tstta.site_detect',
                'tstta.site_name_detect',
                'tstta.tiket_terima',
                'tstta.tacc_nama',
                'tstta.tacc_nik',
                'tao.id AS assign_order_id',
                'tao.order_headline',
                'tro.status_qc_id',
                'tro.coordinates_site',
                'tro.notes AS qc_notes',
                'tro.no_document'
            )
            ->where('tstta.id', $id)
            ->first();
    }

    public static function get_materials($assign_order_id)
    {
        if (empty($assign_order_id))
        {
            return collect();
        }

        return DB::table('tb_report_materials')
            ->where('assign_order_id', $assign_order_id)
            ->select('designator_id', 'qty', 'coordinates_material')
            ->get()
            ->map(function ($item)
            {
                $item->coordinates_material = self::decodeCoordinatesValue($item->coordinates_material);

                return $item;
            });
    }

    public static function get_ticket_alita_detail($id)
    {
        $data = DB::table('tb_source_tacc_ticket_alita_detail')
            ->where('id', $id)
            ->get();

        $response = [];

        if (!$data->isEmpty())
        {
            foreach ($data as $value)
            {
                $keywords = ['Upload evidence berangkat:', 'Upload evidence di site:', 'Evidence pengukuran:', 'Evidence RCA:', 'Evidence perbaikan:', 'link up'];

                foreach ($keywords as $word)
                {
                    if (stripos($value->info, $word) !== false)
                    {
                        if (empty($value->attachment))
                        {
                            continue;
                        }

                        $format = str_replace('https://mtel.tacc.id/storage/bot_file/', '', trim($value->attachment));

                        $response[] = 'https://superbot.warriors.id/bot_lensa_task/Download/evidence/' . $format;

                        break;
                    }
                }
            }
        }

        return array_values(array_filter($response));
    }

    public static function order_post($request)
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
                    'status_qc_id'     => $request->input('status_qc_id'),
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'no_document'      => $request->input('no_document'),
                    'updated_by'       => session('nik') ?? 0,
                    'updated_at'       => now()
                ]);

            DB::table('tb_report_orders_log')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => $request->input('status_qc_id'),
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'no_document'      => $request->input('no_document'),
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
                    $coordinatesMaterial = self::normalizeCoordinatesInput($material['coordinates_material'] ?? null);

                    DB::table('tb_report_materials')
                        ->insert([
                            'assign_order_id'      => $id,
                            'designator_id'        => $material['designator_id'],
                            'qty'                  => $material['qty'],
                            'coordinates_material' => $coordinatesMaterial,
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
                    'status_qc_id'     => $request->input('status_qc_id'),
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'no_document'      => $request->input('no_document'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            DB::table('tb_report_orders_log')
                ->insert([
                    'assign_order_id'  => $id,
                    'status_qc_id'     => $request->input('status_qc_id'),
                    'notes'            => $request->input('notes'),
                    'coordinates_site' => $request->input('coordinates_site'),
                    'no_document'      => $request->input('no_document'),
                    'created_by'       => session('nik') ?? 0,
                    'created_at'       => now()
                ]);

            if ($request->has('materials'))
            {
                foreach ($request->input('materials') as $material)
                {
                    $coordinatesMaterial = self::normalizeCoordinatesInput($material['coordinates_material'] ?? null);

                    DB::table('tb_report_materials')
                        ->insert([
                            'assign_order_id'      => $id,
                            'designator_id'        => $material['designator_id'],
                            'qty'                  => $material['qty'],
                            'coordinates_material' => $coordinatesMaterial,
                            'created_by'           => session('nik') ?? 0,
                            'created_at'           => now()
                        ]);
                }
            }
        }

        $uploadPath = public_path('upload/' . $id);

        if (!File::exists($uploadPath))
        {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $photoFile = $request->file('Foto_Titik_Putus');
        if ($photoFile && $photoFile->isValid())
        {
            $fileName = 'Foto_Titik_Putus.jpg';
            $photoFile->move($uploadPath, $fileName);
        }

        $otdrFile = $request->file('Foto_OTDR');
        if ($otdrFile && $otdrFile->isValid())
        {
            $fileName = 'Foto_OTDR.jpg';
            $otdrFile->move($uploadPath, $fileName);
        }

        $allFiles = $request->allFiles();
        if (!empty($allFiles))
        {
            foreach ($allFiles as $key => $file)
            {
                if (strpos($key, 'attachment_') === 0)
                {
                    if (is_object($file) && method_exists($file, 'isValid') && $file->isValid())
                    {
                        $parts = explode('_', $key);

                        if (count($parts) === 4 && $parts[0] === 'attachment')
                        {
                            $rowIndex = $parts[1];
                            $volumeIndex = $parts[2];
                            $photoType = $parts[3];

                            $attachmentPath = public_path('upload/' . $id . '/attachments/material_' . $rowIndex . '_vol_' . $volumeIndex);

                            if (!File::exists($attachmentPath))
                            {
                                File::makeDirectory($attachmentPath, 0755, true);
                            }

                            $fileName = ucfirst($photoType) . '.jpg';
                            $file->move($attachmentPath, $fileName);
                        }
                    }
                }
            }
        }
    }

    public static function status_post($request)
    {
        $assign_order_id = $request->input('assign_order_id');
        $status_qc_id    = $request->input('status_qc_id');

        DB::table('tb_report_orders')
            ->where('assign_order_id', $assign_order_id)
            ->update([
                'status_qc_id' => $status_qc_id,
                'notes'        => $request->input('notes'),
                'no_document'  => $request->input('no_document'),
                'updated_by'   => session('nik') ?? 0,
                'updated_at'   => now()
            ]);

        DB::table('tb_report_orders_log')
            ->insert([
                'assign_order_id' => $assign_order_id,
                'status_qc_id'    => $status_qc_id,
                'notes'           => $request->input('notes'),
                'no_document'     => $request->input('no_document'),
                'created_by'      => session('nik') ?? 0,
                'created_at'      => now()
            ]);
    }
}
