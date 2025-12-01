<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class DashboardModel extends Model
{
    public function get_monitoring($start_date, $end_date)
    {
        return DB::table('tb_source_tacc_ticket_mtel AS tstm')
            ->leftJoin('tb_assign_orders AS tao', 'tao.order_id', '=', 'tstm.tt_site_id')
            ->leftJoin('tb_report_orders AS tro', 'tro.assign_order_id', '=', 'tao.id')
            ->select(DB::raw('
                tstm.witel AS area,
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
            '))
            ->where('tstm.jenis_perbaikan', 'Temporer')
            ->get();
    }
}
