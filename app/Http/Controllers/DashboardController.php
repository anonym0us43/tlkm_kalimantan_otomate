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

    public function listing()
    {
        return view('dashboard.listing');
    }
}
