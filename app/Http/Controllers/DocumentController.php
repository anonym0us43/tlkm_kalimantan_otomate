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

        $templatePath = public_path('template-documents/Surat_Perintah_Kerja.docx');

        $outputFileName = 'SPK_MTEL_' .
            $data->site_detect . '_' .
            $data->site_name_detect . '_' .
            $data->tt_site . '_' .
            $data->row_id . '.docx';

        $documentsPath = public_path('upload/' . $data->assign_order_id . '/documents');

        if (!File::exists($documentsPath))
        {
            File::makeDirectory($documentsPath, 0755, true);
        }

        $outputPath = $documentsPath . '/' . $outputFileName;

        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('no_document', $data->no_document);
        $templateProcessor->setValue('agenda', '');
        $templateProcessor->setValue('date_document', '');
        $templateProcessor->setValue('tt_site', $data->tt_site);
        $templateProcessor->setValue('no_ioh', $data->row_id);
        $templateProcessor->setValue('order_date', date('Y-m-d', strtotime($data->created_at)));
        $templateProcessor->setValue('order_headline', $data->order_headline);
        $templateProcessor->setValue('ring_id', '');
        $templateProcessor->setValue('site_down', $data->site_down);
        $templateProcessor->setValue('site_name_down', $data->site_name_down);
        $templateProcessor->setValue('site_detect', $data->site_detect);
        $templateProcessor->setValue('site_name_detect', $data->site_name_detect);
        $templateProcessor->setValue('latitude_site_down', $data->latitude_site_down);
        $templateProcessor->setValue('longitude_site_down', $data->longitude_site_down);
        $templateProcessor->setValue('partner_alias', '');
        $templateProcessor->setValue('witel_name', '');

        $templateProcessor->setImageValue(
            'photo_titik_putus',
            [
                'path'   => public_path('upload/' . $data->assign_order_id . '/Foto_Titik_Putus.jpg'),
                'width'  => 280,
                'height' => 245,
                'ratio'  => false
            ]
        );

        $templateProcessor->setImageValue(
            'photo_otdr',
            [
                'path'   => public_path('upload/' . $data->assign_order_id . '/Foto_OTDR.jpg'),
                'width'  => 280,
                'height' => 245,
                'ratio'  => false
            ]
        );

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath);
    }
}
