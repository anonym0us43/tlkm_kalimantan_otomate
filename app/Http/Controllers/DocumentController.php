<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    private function generate_date($date)
    {
        $month = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $tanggal = date('d', strtotime($date));
        $bulan = $month[(int)date('m', strtotime($date))];
        $tahun = date('Y', strtotime($date));

        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    private function escapeValue($value)
    {
        if ($value === null)
        {
            return '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public function generate_spk($id)
    {
        $data = OrderModel::index($id);

        if (!$data)
        {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $templatePath = public_path('template-documents/Surat_Perintah_Kerja.docx');

        if (!File::exists($templatePath))
        {
            return redirect()->back()->with('error', 'Template document not found.');
        }

        $outputFileName = 'SPK_MTEL_' .
            $data->site_detect . '_' .
            $data->site_name_detect . '_' .
            $data->tt_site . '_' .
            $data->ticket_alita_id . '.docx';

        $documentsPath = public_path('upload/' . $data->assign_order_id . '/documents');

        if (!File::exists($documentsPath))
        {
            File::makeDirectory($documentsPath, 0755, true);
        }

        $outputPath = $documentsPath . '/' . $outputFileName;

        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('no_spk', $this->escapeValue($data->no_spk));
        $templateProcessor->setValue('plan', $this->escapeValue($data->plan));
        $dateSPK = $data->date_spk ? $this->generate_date($data->date_spk) : '';
        $templateProcessor->setValue('date_spk', $dateSPK);
        $templateProcessor->setValue('tt_site', $this->escapeValue($data->tt_site));
        $templateProcessor->setValue('no_ioh', $this->escapeValue($data->ticket_alita_id));
        $orderDate = $data->created_at ? $this->generate_date($data->created_at) : '';
        $templateProcessor->setValue('order_date', $orderDate);
        $templateProcessor->setValue('order_headline', $this->escapeValue($data->order_headline));
        $templateProcessor->setValue('ring_id', $this->escapeValue($data->ring_id ?? $data->diginav_ring_id));
        $templateProcessor->setValue('site_down', $this->escapeValue($data->site_down));
        $templateProcessor->setValue('site_name_down', $this->escapeValue($data->site_name_down));
        $templateProcessor->setValue('site_detect', $this->escapeValue($data->site_detect));
        $templateProcessor->setValue('site_name_detect', $this->escapeValue($data->site_name_detect));
        $templateProcessor->setValue('latitude_site_down', $this->escapeValue($data->latitude_site_down));
        $templateProcessor->setValue('longitude_site_down', $this->escapeValue($data->longitude_site_down));
        $templateProcessor->setValue('partner_name', '');
        $templateProcessor->setValue('witel_name', $this->escapeValue($data->witel_name));
        $templateProcessor->setValue('package_id', $this->escapeValue($data->package_id));

        $qty_joint_closure = $qty_cable = 0;
        $data_material = OrderModel::get_materials($data->assign_order_id);

        $templateProcessor->cloneRow('no', count($data_material));

        $totalMaterialPrice = $totalServicePrice = 0;

        foreach ($data_material as $index => $material)
        {
            $rowNumber = $index + 1;

            $templateProcessor->setValue('no#' . $rowNumber, $this->escapeValue($rowNumber));
            $templateProcessor->setValue('item_designator#' . $rowNumber, $this->escapeValue($material->item_designator));
            $templateProcessor->setValue('item_description#' . $rowNumber, $this->escapeValue($material->item_description));
            $templateProcessor->setValue('unit#' . $rowNumber, $this->escapeValue($material->unit));
            $templateProcessor->setValue('material_price#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($material->material_price_mtel, 0, ',', '.')));
            $templateProcessor->setValue('service_price#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($material->service_price_mtel, 0, ',', '.')));
            $templateProcessor->setValue('qty#' . $rowNumber, $this->escapeValue($material->qty));

            $ttlPriceMaterial = $material->material_price_mtel * $material->qty;
            $ttlPriceService = $material->service_price_mtel * $material->qty;
            $templateProcessor->setValue('ttl_price_material#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($ttlPriceMaterial, 0, ',', '.')));
            $templateProcessor->setValue('ttl_price_service#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($ttlPriceService, 0, ',', '.')));

            $totalMaterialPrice += $ttlPriceMaterial;
            $totalServicePrice += $ttlPriceService;

            if (strpos($material->item_designator, 'SC-OF-SM') !== false)
            {
                $qty_joint_closure += $material->qty;
            }
            if (strpos($material->item_designator, 'AC-OF-SM') !== false)
            {
                $qty_cable += $material->qty;
            }
        }

        $templateProcessor->cloneRow('summary_label', 3);

        $templateProcessor->setValue('summary_label#1', $this->escapeValue('Total Material'));
        $templateProcessor->setValue('summary_value#1', $this->escapeValue('Rp. ' . number_format($totalMaterialPrice, 0, ',', '.')));

        $templateProcessor->setValue('summary_label#2', $this->escapeValue('Total Jasa'));
        $templateProcessor->setValue('summary_value#2', $this->escapeValue('Rp. ' . number_format($totalServicePrice, 0, ',', '.')));

        $templateProcessor->setValue('summary_label#3', $this->escapeValue('Total Jasa + Material'));
        $templateProcessor->setValue('summary_value#3', $this->escapeValue('Rp. ' . number_format($totalMaterialPrice + $totalServicePrice, 0, ',', '.')));

        $notePlan1 = "Penggelaran KU " . $qty_cable . " ,Penyambungan " . $qty_joint_closure . " Sisi Joint ";
        $notePlan2 = "Kemudian lanjut Pemasangan " . $qty_joint_closure . " Closure & Terminasi di Joint " . $qty_joint_closure . " Sisi.";

        $templateProcessor->setValue('note_plan1', $this->escapeValue($notePlan1));
        $templateProcessor->setValue('note_plan2', $this->escapeValue($notePlan2));

        $photoTitikPath = public_path('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg');
        $photoOtdrPath  = public_path('upload/' . $data->assign_order_id . '/Foto_OTDR.jpg');

        if (File::exists($photoTitikPath))
        {
            $templateProcessor->setImageValue(
                'photo_titik_putus',
                [
                    'path'   => $photoTitikPath,
                    'width'  => 280,
                    'height' => 245,
                    'ratio'  => true
                ]
            );
        }
        else
        {
            $templateProcessor->setValue('photo_titik_putus', 'Foto Titik Putus tidak tersedia');
        }

        if (File::exists($photoOtdrPath))
        {
            $templateProcessor->setImageValue(
                'photo_otdr',
                [
                    'path'   => $photoOtdrPath,
                    'width'  => 280,
                    'height' => 245,
                    'ratio'  => true
                ]
            );
        }
        else
        {
            $templateProcessor->setValue('photo_otdr', 'Foto OTDR tidak tersedia');
        }

        $photoKmlPath = public_path('upload/' . $data->assign_order_id . '/Foto_KML.jpg');
        if (File::exists($photoKmlPath))
        {
            $templateProcessor->setImageValue(
                'photo_kml',
                [
                    'path'   => $photoKmlPath,
                    'width'  => 280,
                    'height' => 245,
                    'ratio'  => true
                ]
            );
        }
        else
        {
            $templateProcessor->setValue('photo_kml', 'Foto KML tidak tersedia');
        }

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath);
    }

    public function generate_ba_recovery($id)
    {
        $data = OrderModel::index($id);

        if (!$data)
        {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $templatePath = public_path('template-documents/Berita_Acara_Recovery_Mitratel.docx');

        if (!File::exists($templatePath))
        {
            return redirect()->back()->with('error', 'Template document not found.');
        }

        $outputFileName = 'BA_RECOVERY_MTEL_' .
            $data->site_detect . '_' .
            $data->site_name_detect . '_' .
            $data->tt_site . '_' .
            $data->ticket_alita_id . '.docx';

        $documentsPath = public_path('upload/' . $data->assign_order_id . '/documents');

        if (!File::exists($documentsPath))
        {
            File::makeDirectory($documentsPath, 0755, true);
        }

        $outputPath = $documentsPath . '/' . $outputFileName;

        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('project_name', $this->escapeValue($data->project_name));
        $dateBA = $data->date_ba_recovery ? $this->generate_date($data->date_ba_recovery) : '';
        $templateProcessor->setValue('date_ba_recovery', $dateBA);
        $templateProcessor->setValue('partner_name', '');
        $templateProcessor->setValue('witel_name', $this->escapeValue($data->witel_name));
        $templateProcessor->setValue('tt_site', $this->escapeValue($data->tt_site));
        $templateProcessor->setValue('no_ioh', $this->escapeValue($data->ticket_alita_id));
        $templateProcessor->setValue('site_down', $this->escapeValue($data->site_down));
        $templateProcessor->setValue('site_name_down', $this->escapeValue($data->site_name_down));
        $templateProcessor->setValue('site_detect', $this->escapeValue($data->site_detect));
        $templateProcessor->setValue('site_name_detect', $this->escapeValue($data->site_name_detect));
        $templateProcessor->setValue('order_headline', $this->escapeValue($data->order_headline));
        $orderDate = $data->created_at ? $this->generate_date($data->created_at) : '';
        $templateProcessor->setValue('order_date', $orderDate);
        $templateProcessor->setValue('package_id', $this->escapeValue($data->package_id));

        $qty_joint_closure = $qty_cable = 0;
        $data_material = OrderModel::get_materials($data->assign_order_id);

        $templateProcessor->cloneRow('no', count($data_material));

        $totalMaterialPrice = $totalServicePrice = 0;

        foreach ($data_material as $index => $material)
        {
            $rowNumber = $index + 1;

            $templateProcessor->setValue('no#' . $rowNumber, $this->escapeValue($rowNumber));
            $templateProcessor->setValue('item_designator#' . $rowNumber, $this->escapeValue($material->item_designator));
            $templateProcessor->setValue('item_description#' . $rowNumber, $this->escapeValue($material->item_description));
            $templateProcessor->setValue('unit#' . $rowNumber, $this->escapeValue($material->unit));
            $templateProcessor->setValue('material_price#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($material->material_price_mtel, 0, ',', '.')));
            $templateProcessor->setValue('service_price#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($material->service_price_mtel, 0, ',', '.')));
            $templateProcessor->setValue('qty#' . $rowNumber, $this->escapeValue($material->qty));

            $ttlPriceMaterial = $material->material_price_mtel * $material->qty;
            $ttlPriceService = $material->service_price_mtel * $material->qty;
            $templateProcessor->setValue('ttl_price_material#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($ttlPriceMaterial, 0, ',', '.')));
            $templateProcessor->setValue('ttl_price_service#' . $rowNumber, $this->escapeValue('Rp. ' . number_format($ttlPriceService, 0, ',', '.')));

            $totalMaterialPrice += $ttlPriceMaterial;
            $totalServicePrice += $ttlPriceService;

            if (strpos($material->item_designator, 'SC-OF-SM') !== false)
            {
                $qty_joint_closure += $material->qty;
            }
            if (strpos($material->item_designator, 'AC-OF-SM') !== false)
            {
                $qty_cable += $material->qty;
            }
        }

        $templateProcessor->cloneRow('summary_label', 3);

        $templateProcessor->setValue('summary_label#1', $this->escapeValue('Total Material'));
        $templateProcessor->setValue('summary_value#1', $this->escapeValue('Rp. ' . number_format($totalMaterialPrice, 0, ',', '.')));

        $templateProcessor->setValue('summary_label#2', $this->escapeValue('Total Jasa'));
        $templateProcessor->setValue('summary_value#2', $this->escapeValue('Rp. ' . number_format($totalServicePrice, 0, ',', '.')));

        $templateProcessor->setValue('summary_label#3', $this->escapeValue('Total Jasa + Material'));
        $templateProcessor->setValue('summary_value#3', $this->escapeValue('Rp. ' . number_format($totalMaterialPrice + $totalServicePrice, 0, ',', '.')));

        $attachmentBasePath = public_path('upload/' . $data->assign_order_id . '/attachments');
        $evidenceRows = [];

        foreach ($data_material as $materialIndex => $material)
        {
            $designator = $material->item_designator ?? '';
            $requiresMultiple = in_array(substr($designator, 0, 8), ['SC-OF-SM']) || in_array(substr($designator, 0, 4), ['PU-S']);
            $count = $requiresMultiple ? ($material->qty ?? 1) : 1;

            for ($volumeIndex = 0; $volumeIndex < $count; $volumeIndex++)
            {
                $volumePath = $attachmentBasePath . '/material_' . $materialIndex . '_vol_' . $volumeIndex;
                $beforePath   = $volumePath . '/Before.jpg';
                $progressPath = $volumePath . '/Progress.jpg';
                $afterPath    = $volumePath . '/After.jpg';

                $evidenceRows[] = [
                    'no'              => count($evidenceRows) + 1,
                    'item_designator' => $designator . ' (' . ($volumeIndex + 1) . ')',
                    'volume'          => 1,
                    'before'          => File::exists($beforePath) ? $beforePath : null,
                    'progress'        => File::exists($progressPath) ? $progressPath : null,
                    'after'           => File::exists($afterPath) ? $afterPath : null
                ];
            }
        }

        if (!empty($evidenceRows))
        {
            $templateProcessor->cloneRow('photo_before', count($evidenceRows));

            foreach ($evidenceRows as $rowNumber => $row)
            {
                $index = $rowNumber + 1;
                $templateProcessor->setValue('no#' . $index, $this->escapeValue($row['no']));
                $templateProcessor->setValue('item_designator#' . $index, $this->escapeValue($row['item_designator']));
                $templateProcessor->setValue('volume#' . $index, $this->escapeValue($row['volume']));

                if ($row['before'])
                {
                    $templateProcessor->setImageValue('photo_before#' . $index, [
                        'path'   => $row['before'],
                        'width'  => 140,
                        'height' => 105,
                        'ratio'  => true
                    ]);
                }
                else
                {
                    $templateProcessor->setValue('photo_before#' . $index, 'Tidak ada foto');
                }

                if ($row['progress'])
                {
                    $templateProcessor->setImageValue('photo_progress#' . $index, [
                        'path'   => $row['progress'],
                        'width'  => 140,
                        'height' => 105,
                        'ratio'  => true
                    ]);
                }
                else
                {
                    $templateProcessor->setValue('photo_progress#' . $index, 'Tidak ada foto');
                }

                if ($row['after'])
                {
                    $templateProcessor->setImageValue('photo_after#' . $index, [
                        'path'   => $row['after'],
                        'width'  => 140,
                        'height' => 105,
                        'ratio'  => true
                    ]);
                }
                else
                {
                    $templateProcessor->setValue('photo_after#' . $index, 'Tidak ada foto');
                }
            }
        }
        else
        {
            $templateProcessor->setValue('photo_before', 'Evidence belum tersedia');
            $templateProcessor->setValue('photo_progress', 'Evidence belum tersedia');
            $templateProcessor->setValue('photo_after', 'Evidence belum tersedia');
            $templateProcessor->setValue('no', '');
            $templateProcessor->setValue('item_designator', '');
            $templateProcessor->setValue('volume', '');
        }

        $photoKmlPath = public_path('upload/' . $data->assign_order_id . '/Foto_KML.jpg');
        if (File::exists($photoKmlPath))
        {
            $templateProcessor->setImageValue(
                'photo_kml',
                [
                    'path'   => $photoKmlPath,
                    'width'  => 280,
                    'height' => 245,
                    'ratio'  => true
                ]
            );
        }
        else
        {
            $templateProcessor->setValue('photo_kml', 'Foto KML tidak tersedia');
        }

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath);
    }
}
