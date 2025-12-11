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
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 1 THEN tstta.tt_site_id END) AS planning_need_approve_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 2 THEN tstta.tt_site_id END) AS planning_reject_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 3 THEN tstta.tt_site_id END) AS planning_need_approve_mtel,

                COUNT(DISTINCT CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 0
                    AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 1440) THEN tstta.tt_site_id END) AS age_under1d,
                COUNT(DISTINCT CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 1440
                    AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 4320) THEN tstta.tt_site_id END) AS age_1d_to_3d,
                COUNT(DISTINCT CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 4320
                    AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 10080) THEN tstta.tt_site_id END) AS age_3d_to_7d,
                COUNT(DISTINCT CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 10080) THEN tstta.tt_site_id END) AS age_upper7d,

                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 4 THEN tstta.tt_site_id END) AS permanenisasi_need_approve_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 5 THEN tstta.tt_site_id END) AS permanenisasi_reject_ta,
                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 6 THEN tstta.tt_site_id END) AS permanenisasi_need_approve_mtel,

                COUNT(DISTINCT CASE WHEN tro.status_qc_id = 7 THEN tstta.tt_site_id END) AS permanenisasi_rekon
            '))
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
                'tstta.start_time AS tiket_start_time',
                'tstta.tt_site',
                'tstta.site_down',
                'tstta.site_name_down',
                'tstta.latitude_site_down',
                'tstta.longitude_site_down',
                'tstta.site_detect',
                'tstta.site_name_detect',
                'tstta.tiket_terima'
            )
            ->whereRaw('DATE(tstta.tiket_terima) BETWEEN ? AND ?', [$start_date, $end_date])
            ->when(!empty($witel), function ($query) use ($witel)
            {
                return $query->whereIn('tstta.witel', $witel);
            });

        if ($status == 'idle_order')
        {
            $query->whereNull('tao.order_id');
        }
        elseif ($status == 'age_under1d')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 0 AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 1440');
        }
        elseif ($status == 'age_1d_to_3d')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 1440 AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 4320');
        }
        elseif ($status == 'age_3d_to_7d')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 4320 AND TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) <= 10080');
        }
        elseif ($status == 'age_upper7d')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstta.tiket_terima, NOW()) > 10080');
        }
        elseif ($status == 'planning_need_approve_ta')
        {
            $query->where('tro.status_qc_id', 1);
        }
        elseif ($status == 'planning_reject_ta')
        {
            $query->where('tro.status_qc_id', 2);
        }
        elseif ($status == 'planning_need_approve_mtel')
        {
            $query->where('tro.status_qc_id', 3);
        }
        elseif ($status == 'permanenisasi_need_approve_ta')
        {
            $query->where('tro.status_qc_id', 4);
        }
        elseif ($status == 'permanenisasi_reject_ta')
        {
            $query->where('tro.status_qc_id', 5);
        }
        elseif ($status == 'permanenisasi_need_approve_mtel')
        {
            $query->where('tro.status_qc_id', 6);
        }
        elseif ($status == 'permanenisasi_rekon')
        {
            $query->where('tro.status_qc_id', 7);
        }

        return $query->groupBy('tstta.tt_site_id')->get();
    }
}
