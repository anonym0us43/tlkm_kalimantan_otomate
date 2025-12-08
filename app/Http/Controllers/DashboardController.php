<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');

class DashboardController extends Controller
{
    public function monitoring()
    {
        return view('dashboard.monitoring');
    }

    public function monitoring_detail()
    {
        return view('dashboard.monitoring-detail');
    }

    public function rekoncile()
    {
        return view('dashboard.rekoncile');
    }
}
