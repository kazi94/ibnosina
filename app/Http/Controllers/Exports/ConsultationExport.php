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
class ConsultationExport extends Controller
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
                ->setCellValue('B1','Motifs ')
                ->setCellValue('C1','Signes ')
                ->setCellValue('D1','Examens physique ')
                ->setCellValue('E1','Compte rendu  ')
                ->setCellValue('F1','Orientation  ')
                ->setCellValue('G1','Date consultation  ')
                ->setCellValue('H1','Ajouté par  ')
                ->setCellValue('I1','Modifié par  ');
        foreach ($patient->consultations as $education) {
            $i++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$education->id  )
                ->setCellValue('B'.$i,$education->motif )
                ->setCellValue('C'.$i,$education->signe )
                ->setCellValue('D'.$i,$education->examen)
                ->setCellValue('E'.$i,$education->compte_rendu)
                ->setCellValue('F'.$i,$education->orientation)
                ->setCellValue('G'.$i,$education->date_consultation)
                ->setCellValue('H'.$i,$education->userCreate->name. " " .$education->userCreate->prenom);
                //->setCellValue('I'.$i,$education->userUpdate->name. " " .$education->userUpdate->prenom);
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='ConsultationExport_".$patient->nom."_".$patient->prenom."_". Date("Y-m-d H:i:s") .".xls'");
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

