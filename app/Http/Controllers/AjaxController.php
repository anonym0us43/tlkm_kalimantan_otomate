<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardModel;
use App\Models\MapModel;

date_default_timezone_set('Asia/Jakarta');

class AjaxController extends Controller
{
    public function dashboard_monitoring()
    {
        $regional_id = request()->input('regional_id') ?? session('regional_id');
        $witel_id    = request()->input('witel_id') ?? session('witel_id');
        $start_date  = request()->input('start_date') ?? date('Y-m-d');
        $end_date    = request()->input('end_date') ?? date('Y-m-d');

        $data        = DashboardModel::get_monitoring($regional_id, $witel_id, $start_date, $end_date);

        return response()->json($data);
    }

    public function dashboard_monitoring_detail()
    {
        $regional_id = request()->input('regional_id') ?? session('regional_id');
        $witel_id    = request()->input('witel_id') ?? session('witel_id');
        $start_date  = request()->input('start_date') ?? date('Y-m-d');
        $end_date    = request()->input('end_date') ?? date('Y-m-d');
        $status      = request()->input('status') ?? 'ALL';

        $data        = DashboardModel::get_monitoring_detail($regional_id, $witel_id, $start_date, $end_date, $status);

        return response()->json($data);
    }

    public function map_get_sites()
    {
        $data = MapModel::get_all_sites();

        return response()->json($data);
    }

    public function map_get_site_by_id($site_id)
    {
        $data = MapModel::get_site_by_id($site_id);

        return response()->json($data);
    }
}
