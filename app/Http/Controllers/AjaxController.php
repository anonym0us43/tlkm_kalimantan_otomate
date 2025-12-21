<?php

namespace App\Http\Controllers;

use App\Models\MapModel;
use App\Models\SettingModel;
use App\Models\DashboardModel;
use App\Models\OrderModel;

date_default_timezone_set('Asia/Jakarta');

class AjaxController extends Controller
{
    public function dashboard_monitoring()
    {
        $regional_id = request()->input('regional_id') ?? session('regional_id');
        $witel_id    = request()->input('witel_id') ?? session('witel_id');
        $start_date  = request()->input('start_date') ?? date('Y-m-01');
        $end_date    = request()->input('end_date') ?? date('Y-m-d');

        $data        = DashboardModel::get_monitoring($regional_id, $witel_id, $start_date, $end_date);

        return response()->json($data);
    }

    public function dashboard_monitoring_detail()
    {
        $regional_id = request()->input('regional_id');
        $witel_id    = request()->input('witel_id');
        $start_date  = request()->input('start_date') ?? date('Y-m-01');
        $end_date    = request()->input('end_date') ?? date('Y-m-d');
        $status      = request()->input('status') ?? 'ALL';

        if (empty($regional_id))
        {
            $regional_id = 'ALL';
        }
        if (empty($witel_id))
        {
            $witel_id = 'ALL';
        }

        $data        = DashboardModel::get_monitoring_detail($regional_id, $witel_id, $start_date, $end_date, $status);

        return response()->json($data);
    }

    public function map_get_sites()
    {
        $data = MapModel::get_all_sites();

        return response()->json($data);
    }

    public function map_get_site_to_site()
    {
        $site_from = request()->input('site_from');
        $site_to   = request()->input('site_to');

        $data = MapModel::get_site_to_site($site_from, $site_to);

        return response()->json($data);
    }

    public function designator_khs()
    {
        $data = SettingModel::get_designator();

        return response()->json($data);
    }

    public function tacc_ticket_alita_detail()
    {
        $id   = request()->input('id');

        $data = OrderModel::get_ticket_alita_detail($id);

        return response()->json($data);
    }

    public function dashboard_rekoncile()
    {
        $start_date = request()->input('start_date') ?? date('Y-m-01');
        $end_date   = request()->input('end_date') ?? date('Y-m-d');

        $data = DashboardModel::get_rekoncile($start_date, $end_date);

        return response()->json($data);
    }
}
