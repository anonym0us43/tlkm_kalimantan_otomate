<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;

date_default_timezone_set('Asia/Jakarta');

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function planning_post(Request $request)
    {
        OrderModel::planning_post($request);

        return redirect()->back()->with('success', 'Planning order has been saved successfully.');
    }
}
