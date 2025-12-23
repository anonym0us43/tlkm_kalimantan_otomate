<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
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

        $templateProcessor->setValue('no_document', $this->escapeValue($data->no_document));
        $templateProcessor->setValue('plan', $this->escapeValue($data->plan));
        $dateDocument = $data->date_document ? date('Y-m-d', strtotime($data->date_document)) : '';
        $templateProcessor->setValue('date_document', $dateDocument);
        $templateProcessor->setValue('tt_site', $this->escapeValue($data->tt_site));
        $templateProcessor->setValue('no_ioh', $this->escapeValue($data->ticket_alita_id));
        $templateProcessor->setValue('order_date', date('Y-m-d', strtotime($data->created_at)));
        $templateProcessor->setValue('order_headline', $this->escapeValue($data->order_headline));
        $templateProcessor->setValue('ring_id', $this->escapeValue($data->ring_id ?? $data->diginav_ring_id));
        $templateProcessor->setValue('site_down', $this->escapeValue($data->site_down));
        $templateProcessor->setValue('site_name_down', $this->escapeValue($data->site_name_down));
        $templateProcessor->setValue('site_detect', $this->escapeValue($data->site_detect));
        $templateProcessor->setValue('site_name_detect', $this->escapeValue($data->site_name_detect));
        $templateProcessor->setValue('latitude_site_down', $this->escapeValue($data->latitude_site_down));
        $templateProcessor->setValue('longitude_site_down', $this->escapeValue($data->longitude_site_down));
        $templateProcessor->setValue('partner_alias', '');
        $templateProcessor->setValue('witel_name', $this->escapeValue($data->witel_name));

        $qty_joint_closure = $qty_cable = 0;
        $data_material = OrderModel::get_materials($data->assign_order_id);
        foreach ($data_material as $material)
        {
            if (strpos($material->item_designator, 'SC-OF-SM') !== false)
            {
                $qty_joint_closure += $material->qty;
            }
            if (strpos($material->item_designator, 'AC-OF-SM') !== false)
            {
                $qty_cable += $material->qty;
            }
        }
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
                    'ratio'  => false
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
                    'ratio'  => false
                ]
            );
        }
        else
        {
            $templateProcessor->setValue('photo_otdr', 'Foto OTDR tidak tersedia');
        }

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath);
    }

    private function escapeValue($value)
    {
        if ($value === null)
        {
            return '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
