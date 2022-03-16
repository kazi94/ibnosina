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
class hoExport extends Controller
{
    public function export_hospi ($patient_id) {
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
                ->setCellValue('A1','Num ')
                ->setCellValue('B1','Service ')
                ->setCellValue('C1','Num Billet ')
                ->setCellValue('D1','Chambre ')
                ->setCellValue('E1','Lit  ')
                ->setCellValue('F1','Date_admission ')
                ->setCellValue('G1','Date_sortie  ')
                ->setCellValue('H1','Par  '); 
        foreach ($patient->hospitalisation as $ho) {
            $i++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$ho->id  )
                ->setCellValue('B'.$i,$ho->service )
                ->setCellValue('C'.$i,$ho->num_biais )
                ->setCellValue('D'.$i,$ho->chambre)
                ->setCellValue('E'.$i,$ho->lit)
                ->setCellValue('F'.$i,$ho->date_admission)
                ->setCellValue('G'.$i,$ho->date_sortie)
                ->setCellValue('H'.$i,$ho->patient_id);
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Hospitalisation_".$patient->nom."_".$patient->prenom."_". gmdate('D, dM-Y-H-i') .".xls'");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }
}

