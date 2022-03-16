<?php
namespace App\Http\Controllers\Exports;
use DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Patient;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Excel;
class PhytoExport extends Controller
{
    public function export_bilan ($patient_id) {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');
        $patient = Patient::find($patient_id);
        $i = 1;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1','Num')
            ->setCellValue('B1','Produit Fr ')
            ->setCellValue('C1','Produits arabe')
            ->setCellValue('D1','Fréquence')
            ->setCellValue('E1','Depuis');
        foreach ($patient->phytos as $phyto) {
            $i++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$phyto->id )
                ->setCellValue('B'.$i,$phyto->produit['produit_naturel_fr'] )
                ->setCellValue('C'.$i,$phyto->produit['produits_arabe'])
                ->setCellValue('D'.$i,$phyto->frequence)
                ->setCellValue('E'.$i,$phyto->frequence_date );
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Bilans_".$patient->nom."_".$patient->prenom."_". Date("Y-m-d H:i:s").".xls'");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . Date("Y-m-d H:i:s") . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }
}

