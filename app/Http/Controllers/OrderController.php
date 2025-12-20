<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\SettingModel;
use Illuminate\Support\Facades\File;

date_default_timezone_set('Asia/Jakarta');

class OrderController extends Controller
{
    public function index($id)
    {
        $data = OrderModel::index($id);

        $materials = collect();
        $existingPhotoUrl = null;
        $existingAttachments = [];

        if ($data && $data->assign_order_id)
        {
            $materials = OrderModel::get_materials($data->assign_order_id);

            $photoPath = public_path('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            if (File::exists($photoPath))
            {
                $existingPhotoUrl = asset('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            }

            $attachmentBasePath = public_path('upload/' . $data->assign_order_id . '/attachments');
            if (File::exists($attachmentBasePath))
            {
                foreach ($materials as $materialIndex => $material)
                {
                    $designatorId = $material->designator_id;
                    $materialData = SettingModel::get_designator()->firstWhere('id', $designatorId);
                    $designator = $materialData->item_designator ?? '';

                    $requiresMultiple = in_array(substr($designator, 0, 8), ['SC-OF-SM']) ||
                        in_array(substr($designator, 0, 4), ['PU-S']);
                    $count = $requiresMultiple ? $material->qty : 1;

                    for ($volumeIndex = 0; $volumeIndex < $count; $volumeIndex++)
                    {
                        $volumePath = $attachmentBasePath . '/material_' . $materialIndex . '_vol_' . $volumeIndex;

                        if (File::exists($volumePath))
                        {
                            foreach (['before', 'progress', 'after'] as $photoType)
                            {
                                $fileName = ucfirst($photoType) . '.jpg';
                                $filePath = $volumePath . '/' . $fileName;

                                if (File::exists($filePath))
                                {
                                    $existingAttachments[$materialIndex][$volumeIndex][$photoType] =
                                        asset('upload/' . $data->assign_order_id . '/attachments/material_' . $materialIndex . '_vol_' . $volumeIndex . '/' . $fileName);
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!$data)
        {
            return redirect()->back()->with('error', 'Data not found.');
        }

        return view('order.index', compact('id', 'data', 'materials', 'existingPhotoUrl', 'existingAttachments'));
    }

    public function order_post(Request $request)
    {
        OrderModel::order_post($request);

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
