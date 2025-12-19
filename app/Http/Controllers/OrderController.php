<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class OrderController extends Controller
{
    public function index($id)
    {
        $data = OrderModel::index($id);

        if (!$data)
        {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('order.index', compact('id', 'data'));
    }

    public function planning_post(Request $request)
    {
        OrderModel::planning_post($request);

        return redirect()->back()->with('success', 'Planning order has been saved successfully.');
    }
}
