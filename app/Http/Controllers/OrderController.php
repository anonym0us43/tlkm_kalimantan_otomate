<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\SettingModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');

class OrderController extends Controller
{
    public function index($id)
    {
        $data = OrderModel::index($id);

        $materials = collect();
        $existingPhotoUrl = null;
        $existingPhotoOtdrUrl = null;
        $existingAttachments = [];

        if ($data && $data->assign_order_id)
        {
            $materials = OrderModel::get_materials($data->assign_order_id);

            $photoPath = public_path('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            if (File::exists($photoPath))
            {
                $existingPhotoUrl = asset('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
            }

            $photoOtdrPath = public_path('upload/' . $data->assign_order_id . '/Foto_OTDR.jpg');
            if (File::exists($photoOtdrPath))
            {
                $existingPhotoOtdrUrl = asset('upload/' . $data->assign_order_id . '/Foto_OTDR.jpg');
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

        return view('order.index', compact('id', 'data', 'materials', 'existingPhotoUrl', 'existingPhotoOtdrUrl', 'existingAttachments'));
    }

    public function order_post(Request $request)
    {
        $request->validate([
            'order_headline'            => 'required|string',
            'coordinates_site'          => 'required|string',
            'Foto_Titik_Putus'          => 'nullable|image|mimes: jpeg,jpg,png|max: 10240',
            'Foto_OTDR'                 => 'nullable|image|mimes: jpeg,jpg,png|max: 10240',
            'materials'                 => 'required|array|min  : 1',
            'materials.*.designator_id' => 'required|integer',
            'materials.*.qty'           => 'required|integer|min:1',
        ], [
            'order_headline.required'            => 'Penyebab putus wajib diisi',
            'coordinates_site.required'          => 'Koordinat titik putus wajib diisi',
            'materials.required'                 => 'Material wajib diisi',
            'materials.min'                      => 'Minimal harus ada satu material',
            'materials.*.designator_id.required' => 'Designator material wajib dipilih',
            'materials.*.qty.required'           => 'Quantity material wajib diisi',
            'materials.*.qty.min'                => 'Quantity material minimal 1',
        ]);

        $existingRecord = DB::table('tb_assign_orders')
            ->where('order_id', $request->input('order_id'))
            ->orWhere('order_code', $request->input('order_code'))
            ->first();

        if (!$existingRecord)
        {
            $request->validate([
                'Foto_Titik_Putus' => 'required|image|mimes: jpeg,jpg,png|max: 10240',
                'Foto_OTDR'        => 'required|image|mimes: jpeg,jpg,png|max: 10240',
            ], [
                'Foto_Titik_Putus.required' => 'Foto Titik Putus wajib diupload',
                'Foto_OTDR.required'        => 'Foto OTDR wajib diupload',
            ]);
        }
        else
        {
            $uploadPath = public_path('upload/' . $existingRecord->id);
            $hasFotoTitikPutus = File::exists($uploadPath . '/Foto_Titik_Putus.jpg') || $request->hasFile('Foto_Titik_Putus');
            $hasFotoOtdr = File::exists($uploadPath . '/Foto_OTDR.jpg') || $request->hasFile('Foto_OTDR');

            if (!$hasFotoTitikPutus)
            {
                return redirect()->back()->withErrors(['Foto_Titik_Putus' => 'Foto Titik Putus wajib diupload'])->withInput();
            }

            if (!$hasFotoOtdr)
            {
                return redirect()->back()->withErrors(['Foto_OTDR' => 'Foto OTDR wajib diupload'])->withInput();
            }
        }

        $currentStatusQcId = $request->input('status_qc_id', 2);

        if ($currentStatusQcId == 3)
        {
            $allAttachmentsComplete = $this->checkAllAttachmentsComplete($request, $existingRecord);

            if ($allAttachmentsComplete)
            {
                $request->merge(['status_qc_id' => 5]);
            }
        }

        OrderModel::order_post($request);

        return redirect()->back()->with('success', 'Order has been saved successfully.');
    }

    private function checkAllAttachmentsComplete($request, $existingRecord)
    {
        $allFiles = $request->allFiles();
        $hasNewAttachments = false;

        foreach ($allFiles as $key => $file)
        {
            if (strpos($key, 'attachment_') === 0)
            {
                $hasNewAttachments = true;
                break;
            }
        }

        if (!$hasNewAttachments && $existingRecord)
        {
            $attachmentBasePath = public_path('upload/' . $existingRecord->id . '/attachments');

            if (File::exists($attachmentBasePath))
            {
                $materials = $request->input('materials', []);

                foreach ($materials as $materialIndex => $material)
                {
                    $designatorId = $material['designator_id'] ?? null;

                    if (!$designatorId) continue;

                    $materialData = SettingModel::get_designator()->firstWhere('id', $designatorId);
                    $designator = $materialData->item_designator ?? '';

                    $requiresMultiple = in_array(substr($designator, 0, 8), ['SC-OF-SM']) ||
                        in_array(substr($designator, 0, 4), ['PU-S']);
                    $qty = $material['qty'] ?? 1;
                    $count = $requiresMultiple ? $qty : 1;

                    for ($volumeIndex = 0; $volumeIndex < $count; $volumeIndex++)
                    {
                        $volumePath = $attachmentBasePath . '/material_' . $materialIndex . '_vol_' . $volumeIndex;

                        foreach (['Before', 'Progress', 'After'] as $photoType)
                        {
                            $filePath = $volumePath . '/' . $photoType . '.jpg';

                            if (!File::exists($filePath))
                            {
                                return false;
                            }
                        }
                    }
                }

                return true;
            }

            return false;
        }

        if ($hasNewAttachments)
        {
            $materials = $request->input('materials', []);

            foreach ($materials as $materialIndex => $material)
            {
                $designatorId = $material['designator_id'] ?? null;

                if (!$designatorId) continue;

                $materialData = SettingModel::get_designator()->firstWhere('id', $designatorId);
                $designator = $materialData->item_designator ?? '';

                $requiresMultiple = in_array(substr($designator, 0, 8), ['SC-OF-SM']) ||
                    in_array(substr($designator, 0, 4), ['PU-S']);
                $qty = $material['qty'] ?? 1;
                $count = $requiresMultiple ? $qty : 1;

                for ($volumeIndex = 0; $volumeIndex < $count; $volumeIndex++)
                {
                    foreach (['before', 'progress', 'after'] as $photoType)
                    {
                        $attachmentKey = "attachment_{$materialIndex}_{$volumeIndex}_{$photoType}";

                        $hasFile = $request->hasFile($attachmentKey);

                        if (!$hasFile && $existingRecord)
                        {
                            $existingPath = public_path('upload/' . $existingRecord->id . '/attachments/material_' . $materialIndex . '_vol_' . $volumeIndex . '/' . ucfirst($photoType) . '.jpg');
                            $hasFile = File::exists($existingPath);
                        }

                        if (!$hasFile)
                        {
                            return false;
                        }
                    }
                }
            }

            return true;
        }

        return false;
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
