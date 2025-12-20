<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

date_default_timezone_set('Asia/Jakarta');

class OrderController extends Controller
{
    public function index($id)
    {
        $data = OrderModel::index($id);

        $materials = collect();
        $existingPhotoUrl = null;

        if ($data && $data->assign_order_id)
        {
            $materials = OrderModel::get_materials($data->assign_order_id);

            $photoPath = public_path('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            if (File::exists($photoPath))
            {
                $existingPhotoUrl = asset('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            }
        }

        if (!$data)
        {
            return redirect()->back()->with('error', 'Data not found.');
        }

        return view('order.index', compact('id', 'data', 'materials', 'existingPhotoUrl'));
    }

    public function planning_post(Request $request)
    {
        OrderModel::planning_post($request);

        return redirect()->back()->with('success', 'Planning order has been saved successfully.');
    }

    public function status_post(Request $request)
    {
        if (session('partner_alias') !== 'MTEL')
        {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        OrderModel::status_post($request);

        return redirect()->back()->with('success', 'Status order has been updated successfully.');
    }
}
