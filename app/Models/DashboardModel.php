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

        $query = DB::table('tb_source_tacc_ticket_mtel AS tstm')
            ->leftJoin('tb_assign_orders AS tao', 'tstm.tt_site_id', '=', 'tao.order_id')
            ->leftJoin('tb_project AS tp', 'tao.project_id', '=', 'tp.id')
            ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
            ->leftJoin('tb_report_qc AS trq', 'tro.id', '=', 'trq.report_order_id')
            ->leftJoin('tb_status_qc AS tsq', 'trq.status_qc_id', '=', 'tsq.id')
            ->leftJoin('tb_witel AS tw', 'tstm.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select(DB::raw('
                tr.id AS regional_id,
                tr.name AS regional_name,

                tw.id AS witel_id,
                tw.name AS witel_name,

                SUM(CASE WHEN tao.order_id IS NULL THEN 1 ELSE 0 END) AS idle_order,
                SUM(CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 0
                    AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 4320) THEN 1 ELSE 0 END) AS under3d_order,
                SUM(CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 4320
                    AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 10080) THEN 1 ELSE 0 END) AS under7d_order,
                SUM(CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 10080
                    AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 20160) THEN 1 ELSE 0 END) AS under14d_order,
                SUM(CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 20160
                    AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 43200) THEN 1 ELSE 0 END) AS under30d_order,
                SUM(CASE WHEN tao.order_id IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 43200) THEN 1 ELSE 0 END) AS upper30d_order,
                SUM(CASE WHEN tsq.name = "Reject TA" THEN 1 ELSE 0 END) AS reject_ta,
                SUM(CASE WHEN tsq.name = "Approval TA" THEN 1 ELSE 0 END) AS approval_ta,
                SUM(CASE WHEN tsq.name = "Reject MTEL" THEN 1 ELSE 0 END) AS reject_mtel,
                SUM(CASE WHEN tsq.name = "Done" THEN 1 ELSE 0 END) AS done_mtel,
                SUM(CASE WHEN tsq.name = "Rekoncile" THEN 1 ELSE 0 END) AS reconcile_mtel

            '))
            ->whereRaw('DATE(tstm.tiket_terima) BETWEEN ? AND ?', [$start_date, $end_date])
            ->when(!empty($witel), function ($query) use ($witel)
            {
                return $query->whereIn('tstm.witel', $witel);
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

        $query = DB::table('tb_source_tacc_ticket_mtel AS tstm')
            ->leftJoin('tb_assign_orders AS tao', 'tstm.tt_site_id', '=', 'tao.order_id')
            ->leftJoin('tb_project AS tp', 'tao.project_id', '=', 'tp.id')
            ->leftJoin('tb_report_orders AS tro', 'tao.id', '=', 'tro.assign_order_id')
            ->leftJoin('tb_report_qc AS trq', 'tro.id', '=', 'trq.report_order_id')
            ->leftJoin('tb_status_qc AS tsq', 'trq.status_qc_id', '=', 'tsq.id')
            ->leftJoin('tb_witel AS tw', 'tstm.witel', '=', 'tw.name')
            ->leftJoin('tb_regional AS tr', 'tr.id', '=', 'tw.regional_id')
            ->select('tstm.*', 'tp.project_name', 'tao.order_id', 'tro.id AS report_order_id', 'tsq.name AS status_qc_name')
            ->whereRaw('DATE(tstm.tiket_terima) BETWEEN ? AND ?', [$start_date, $end_date])
            ->when(!empty($witel), function ($query) use ($witel)
            {
                return $query->whereIn('tstm.witel', $witel);
            });

        if ($status == 'idle_order')
        {
            $query->whereNull('tao.order_id');
        }
        elseif ($status == 'under3d_order')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 0 AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 4320');
        }
        elseif ($status == 'under7d_order')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 4320 AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 10080');
        }
        elseif ($status == 'under14d_order')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 10080 AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 20160');
        }
        elseif ($status == 'under30d_order')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 20160 AND TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) <= 43200');
        }
        elseif ($status == 'upper30d_order')
        {
            $query->whereNotNull('tao.order_id')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, tstm.tiket_terima, NOW()) > 43200');
        }
        elseif ($status == 'reject_ta')
        {
            $query->where('tsq.name', 'Reject TA');
        }
        elseif ($status == 'approval_ta')
        {
            $query->where('tsq.name', 'Approval TA');
        }
        elseif ($status == 'reject_mtel')
        {
            $query->where('tsq.name', 'Reject MTEL');
        }
        elseif ($status == 'done_mtel')
        {
            $query->where('tsq.name', 'Done');
        }
        elseif ($status == 'reconcile_mtel')
        {
            $query->where('tsq.name', 'Rekoncile');
        }

        return $query->get();
    }
}
