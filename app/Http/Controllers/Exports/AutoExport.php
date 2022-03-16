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
class AutoExport extends Controller
{
    public function export_bilan ($patient_id) {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('')
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
                ->setCellValue('B1','Medicament ')
                ->setCellValue('C1','Voie ')
                ->setCellValue('D1','Matin ')
                ->setCellValue('E1','Midi  ')
                ->setCellValue('F1','Soir   ')
                ->setCellValue('G1','Avant-coucher  ')
                ->setCellValue('H1','Etats')
                ->setCellValue('I1',' Date etats')
                ->setCellValue('J1', 'Medecin externe')
                ->setCellValue('K1', 'Hopital');
        foreach ($patient->autos as $traitement) {
            foreach ($traitement->lignes as $ligne) {
             $i++;
                $resultats = DB::table('cosac_compo_subact')
                            ->join('sac_subactive as t0','t0.SAC_CODE_SQ_PK' , 'cosac_compo_subact.cosac_sac_code_fk_pk')
                            ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                            ->where('cosac_compo_subact.cosac_sp_code_fk_pk' , $ligne->med_sp_id)
                            ->get();
                foreach ($resultats as $key => $resultat) {
                    $medi = $resultat->sac_nom." ". $resultat->cosac_dosage .$resultat->cosac_unitedosage.( ($key == (count($resultats)-1)) ? '.' : '/' ); 
                }
                if ($ligne->status_hopital == '1') {
                    $hop ="oui";
                } else $hop = "non";
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$i-1 )
                ->setCellValue('B'.$i,$medi)
                ->setCellValue('C'.$i,$ligne->voie )
                ->setCellValue('D'.$i,$ligne->dose_matin." ".$ligne->repas_matin)
                ->setCellValue('E'.$i,$ligne->dose_midi." ".$ligne->repas_midi)
                ->setCellValue('F'.$i,$ligne->dose_soir." ".$ligne->repas_soir)
                ->setCellValue('G'.$i,$ligne->dose_avant_coucher)
                ->setCellValue('H'.$i,$ligne->etats  )
                ->setCellValue('I'.$i, $ligne->date_etats )
                ->setCellValue('J'.$i, $ligne->medecin_externe)

                ->setCellValue('K'.$i, $hop);               
            }

        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='automedication_".$patient->nom."_".$patient->prenom."_". Date("Y-m-d H:i:s").".xls'");
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

