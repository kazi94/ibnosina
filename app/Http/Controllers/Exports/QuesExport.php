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
class QuesExport extends Controller
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

        $bilans = DB::table('questionnaires')
                    ->select(DB::raw('SUM(reponse) as reponse'),'date_questionnaire','question_id','user_id','users.name','users.prenom')
                    ->join('users','users.id','questionnaires.user_id')
                    ->where ('patient_id',$patient_id)
                    ->groupBy('date_questionnaire','patient_id')
                    
                    ->get();
        $k = 0;
        $i = 1;
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1','num')
                ->setCellValue('B1','date_questionnaire Morisky')
                ->setCellValue('C1','Observation ')
                ->setCellValue('D1','Par ');
                
        foreach ($bilans as $bilan) {
            $i++;
            if ($bilan->reponse == "1" || $bilan->reponse =="2") $observation = "Patient modérément observant";
               else if ($bilan->reponse == "3" || $bilan->reponse == "4") $observation ="Patient très observant";
                    else $observation="Patient non observant";
                                                    
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,++$k)
                ->setCellValue('B'.$i,$bilan->date_questionnaire )
                ->setCellValue('C'.$i,$observation)
                ->setCellValue('D'.$i,$bilan->name." ".$bilan->prenom  );
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Questionnaires_Morisky_".$patient->nom."_".$patient->prenom."_". Date("Y-m-d H:i:s") .".xls'");
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

