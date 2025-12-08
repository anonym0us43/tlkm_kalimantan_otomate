<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');

class MapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }

    public function site_to_site()
    {
        $site_from = request()->get('site_from');
        $site_to   = request()->get('site_to');

        return view('map.site-to-site', compact('site_from', 'site_to'));
    }
}
