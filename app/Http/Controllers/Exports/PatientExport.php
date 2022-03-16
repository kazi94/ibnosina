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
use Illuminate\Http\Request;

class PatientExport extends Controller
{
    public function exportPatientsWithBilans(Request $request)
    {
        $patients = Patient::whereBetween('created_at', [$request->dateD, $request->dateF])
            ->with(
                'dedimere:patient_id,valeur',
                'fib:patient_id,valeur',
                'gb:patient_id,valeur',
                'crp:patient_id,valeur',
                'pcr:patient_id,valeur',
                'tp:patient_id,valeur',
                'tdm:patient_id,attack_rate'
            )
            ->get();
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
        $i = 1;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Patients')
            ->setCellValue('B1', 'Ddimère ')
            ->setCellValue('C1', 'Fibrinogène ')
            ->setCellValue('D1', 'GB')
            ->setCellValue('E1', 'CRP ')
            ->setCellValue('F1', 'PCR')
            ->setCellValue('G1', 'TP')
            ->setCellValue('H1', 'TDM');
        foreach ($patients as $patient) {

            $i++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $patient->nom . " " . $patient->prenom)
                ->setCellValue('B' . $i, $patient->dedimere ? $patient->dedimere->valeur : '')
                ->setCellValue('C' . $i, $patient->fib ?  $patient->fib->valeur : '')
                ->setCellValue('D' . $i, $patient->gb ? $patient->gb->valeur : '')
                ->setCellValue('E' . $i, $patient->crp ? $patient->crp->valeur : '')
                ->setCellValue('F' . $i, $patient->pcr ? $patient->pcr->valeur : '')
                ->setCellValue('G' . $i, $patient->tp ? $patient->tp->valeur : '')
                ->setCellValue('H' . $i, $patient->tdm ? $patient->tdm->attack_rate : '');

            //->setCellValue('I'.$i,$education->userUpdate->name. " " .$education->userUpdate->prenom);
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=Patients_" . Date("Y-m-d H:i:s") . ".xls");
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
