<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class DashboardModel extends Model
{
    public static function get_monitoring($regional_id, $witel_id, $start_date, $end_date)
    {
        $witel = [];

        if ($regional_id != 'ALL')
        {
            if ($witel_id != 'ALL')
            {
                $witel = DB::table('tb_witel')->where('id', $witel_id)->pluck('name')->toArray();
            }
            else
            {
                $witel = DB::table('tb_witel')->where('regional_id', $regional_id)->pluck('name')->toArray();
            }
        }

        $query = DB::table('tb_source_tacc_ticket_alita AS tstta')
            ->leftJoin('tb_assign_orders AS tao', 'tstta.tt_site_id', '=', 'tao.order_id')
            ->leftJoin('tb_project AS tp', 'tao.project_id', '=', 'tp.id')
            ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
            ->leftJoin('tb_status_qc AS tsq', 'tro.status_qc_id', '=', 'tsq.id')
            ->leftJoin('tb_witel AS tw', 'tstta.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select(DB::raw('
                tr.id AS regional_id,
                tr.name AS regional_name,

                tw.id AS witel_id,
                tw.name AS witel_name,

                COUNT(DISTINCT CASE WHEN tao.order_id IS NULL THEN tstta.tt_site_id END) AS idle_order,

                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 1 THEN tstta.tt_site_id END) AS planning_reject_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 2 THEN tstta.tt_site_id END) AS planning_need_approve_mtel,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 3 THEN tstta.tt_site_id END) AS planning_approve_mtel,

                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 4 THEN tstta.tt_site_id END) AS permanenisasi_reject_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 5 THEN tstta.tt_site_id END) AS permanenisasi_need_approve_mtel,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 6 THEN tstta.tt_site_id END) AS permanenisasi_rekon
            '))
            ->where('tstta.jenis_perbaikan', 'Temporer')
            ->whereRaw('DATE(tstta.tiket_terima) BETWEEN ? AND ?', [$start_date, $end_date])
            ->when(!empty($witel), function ($query) use ($witel)
            {
                return $query->whereIn('tstta.witel', $witel);
            });

        return $query->groupBy('tr.id', 'tw.id')->get();
    }

    public static function get_monitoring_detail($regional_id, $witel_id, $start_date, $end_date, $status)
    {
        $witel = [];

        if ($regional_id != 'ALL')
        {
            if ($witel_id != 'ALL')
            {
                $witel = DB::table('tb_witel')->where('id', $witel_id)->pluck('name')->toArray();
            }
            else
            {
                $witel = DB::table('tb_witel')->where('regional_id', $regional_id)->pluck('name')->toArray();
            }
        }

        $query = DB::table('tb_source_tacc_ticket_alita AS tstta')
            ->leftJoin('tb_assign_orders AS tao', 'tstta.tt_site_id', '=', 'tao.order_id')
            ->leftJoin('tb_project AS tp', 'tao.project_id', '=', 'tp.id')
            ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
            ->leftJoin('tb_status_qc AS tsq', 'tro.status_qc_id', '=', 'tsq.id')
            ->leftJoin('tb_witel AS tw', 'tstta.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select(
                'tstta.id AS row_id',
                'tstta.tt_site_id',
                'tr.name AS regional_name',
                'tw.name AS witel_name',
                'tstta.created_at',
                'tstta.tt_site',
                'tstta.site_down',
                'tstta.site_name_down',
                'tstta.latitude_site_down',
                'tstta.longitude_site_down',
                'tstta.site_detect',
                'tstta.site_name_detect',
                'tstta.tiket_terima',
                'tstta.tacc_nama',
                'tstta.tacc_nik'
            )
            ->where('tstta.jenis_perbaikan', 'Temporer')
            ->whereRaw('DATE(tstta.tiket_terima) BETWEEN ? AND ?', [$start_date, $end_date])
            ->when(!empty($witel), function ($query) use ($witel)
            {
                return $query->whereIn('tstta.witel', $witel);
            });

        if ($status == 'idle_order')
        {
            $query->whereNull('tao.order_id');
        }
        elseif ($status == 'planning_reject_ta')
        {
            $query->where('tro.status_qc_id', 1);
        }
        elseif ($status == 'planning_need_approve_mtel')
        {
            $query->where('tro.status_qc_id', 2);
        }
        elseif ($status == 'planning_approve_mtel')
        {
            $query->where('tro.status_qc_id', 3);
        }
        elseif ($status == 'permanenisasi_reject_ta')
        {
            $query->where('tro.status_qc_id', 4);
        }
        elseif ($status == 'permanenisasi_need_approve_mtel')
        {
            $query->where('tro.status_qc_id', 5);
        }
        elseif ($status == 'permanenisasi_rekon')
        {
            $query->where('tro.status_qc_id', 6);
        }

        return $query->groupBy('tstta.tt_site_id')->get();
    }

    public static function get_rekoncile()
    {
        $witels = DB::table('tb_witel')->select('name')->distinct()->orderBy('name')->pluck('name')->toArray();

        $rekoncileData = [];

        foreach ($witels as $witel)
        {
            $data = DB::table('tb_source_tacc_ticket_alita AS tstta')
                ->leftJoin('tb_assign_orders AS tao', 'tstta.tt_site_id', '=', 'tao.order_id')
                ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
                ->leftJoin('tb_report_materials AS trm', 'tro.assign_order_id', '=', 'trm.assign_order_id')
                ->leftJoin('tb_designator_khs AS tdkh', 'trm.designator_id', '=', 'tdkh.id')
                ->where('tstta.witel', $witel)
                ->where('tstta.jenis_perbaikan', 'Temporer')
                ->select(
                    'tstta.tt_site_id',
                    'tro.status_qc_id',
                    DB::raw('SUM(COALESCE(tdkh.material_price_mtel, 0) * COALESCE(trm.qty, 0)) AS total_material'),
                    DB::raw('SUM(COALESCE(tdkh.service_price_mtel, 0) * COALESCE(trm.qty, 0)) AS total_jasa')
                )
                ->groupBy('tstta.tt_site_id', 'tro.status_qc_id')
                ->get();

            $statusData = [
                0 => 0,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0
            ];

            foreach ($data as $row)
            {
                $status = $row->status_qc_id ?? 0;
                $totalCost = ($row->total_material ?? 0) + ($row->total_jasa ?? 0);
                $statusData[$status] += $totalCost;
            }

            $rekoncileData[] = [
                'witel' => $witel,
                'planning_indikasi' => $statusData[0],
                'planning_reject' => $statusData[1],
                'planning_need_approve' => $statusData[2],
                'progress' => $statusData[3],
                'permanenisasi_reject' => $statusData[4],
                'permanenisasi_need_approve' => $statusData[5],
                'rekon' => $statusData[6]
            ];
        }

        return $rekoncileData;
    }
}
