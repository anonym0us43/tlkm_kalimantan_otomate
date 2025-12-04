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

    public function coordiate_to_coordinate()
    {
        $coordinate_from = request()->get('coordinate_from');
        $coordinate_to   = request()->get('coordinate_to');

        return view('map.coordinate-to-coordinate', compact('coordinate_from', 'coordinate_to'));
    }
}
