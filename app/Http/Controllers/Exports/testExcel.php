<?php
namespace App\Http\Controllers\Exports;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Patient;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Excel;
class testExcel extends Controller 
{   
 // public function readCell($column, $row, $worksheetName = '') {
 //        // Read title row and rows 20 - 30
 //        if ($row == 1 || ($row >= 20 && $row <= 30)) {
 //            return true;
 //        }
 //        return false;
 //    }

    // public function export_bilan (Request $request) {
    //             $file = $request->file('file');
    //             return  $file;
    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //     $reader->setLoadAllSheets();
    //     $spreadsheet = $reader->load();
//         /****************************INFORMATIONS***************************************************/
//         // var_dump($spreadsheet->getSheetNames()) ; // retourne un tableau des nom des pages
//         // var_dump($spreadsheet->getSheetByName('page 1')) ; // retourne 'page 1' sheet  object
//         // var_dump($spreadsheet->getSheet(0)) ; // Same as getSheetByname
//         // var_dump($spreadsheet->getAllSheets()) ; // get all sheets object
//         // foreach ($spreadsheet->getWorksheetIterator() as $sheetnames) { //iterrate in each sheets object
//         //     var_dump($sheetnames) ;
//         //  }
//         /*********************************FIN********************************************************/
// ini_set('max_execution_time', '300');
//         echo "<table>";
//         foreach ($spreadsheet->getAllSheets() as $sheetIndex => $sheetnames) { 
//             echo "/**********".$sheetIndex."*********************/<br/>";
//             $lastRow = $sheetnames->getHighestRow();           
//             for ($i=6; $i < $lastRow; $i++) 
//             { 
//                 $cel = $sheetnames->getCell('A'.($i+1))->getValue();
//                 $cel1 = $sheetnames->getCell('F'.($i+1))->getValue();
//                 echo "<tr><td>".$i."</td><td>".$cel ."</td><td>".$cel1."</td></tr>";
//                   // if (isset($cel)) {
//                   //       $id = DB::table('sp_specialite')->insertGetId([
//                   //               'SP_NOM'=> $cel,
//                   //               'sp_algerie'=> 1]);
//                   //       DB::table('pre_presentation')->insert([
//                   //               "pre_code_pk" => $id,
//                   //               "pre_cdf_up_code_fk" => null,
//                   //               "pre_sp_code_fk" =>$id]);
//                   //       DB::table('spvo_specialite_voie')->insert([
//                   //               "spvo_cdf_vo_code_fk_pk" => 400,
//                   //               "spvo_sp_code_fk_pk" =>$id]);
//                   // }

//                   // if (isset($cel1)) 
//                   // {

//                   //   $id = DB::table('sp_specialite')->insertGetId([
//                   //           'SP_NOM'=> $cel1,
//                   //           'sp_algerie'=> 1]);
//                   //   DB::table('pre_presentation')->insert([
//                   //           "pre_code_pk" => $id,
//                   //           "pre_cdf_up_code_fk" => null,
//                   //           "pre_sp_code_fk" =>$id]);
//                   //   DB::table('spvo_specialite_voie')->insert([
//                   //           "spvo_cdf_vo_code_fk_pk" => 400,
//                   //           "spvo_sp_code_fk_pk" =>$id]);          
//                   // }               
//             }        
//         }
//         echo "</table>";

   // }

        // to read pdf bilan file
        public function export_bilan (Request $request) {
                $pdf_file = $request->file;
if (!is_readable($pdf_file)) {
        print("Error: file does not exist or is not readable: $pdf_file\n");
        return;
}
$c = curl_init();
$cfile = curl_file_create($pdf_file, 'application/pdf');
$apikey = 'q70wivqviidw'; // from https://pdftables.com/api
curl_setopt($c, CURLOPT_URL, "https://pdftables.com/api?key=$apikey&format=csv");
curl_setopt($c, CURLOPT_POSTFIELDS, array('file' => $cfile));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_FAILONERROR,true);
curl_setopt($c, CURLOPT_ENCODING, "gzip,deflate");
$result = curl_exec($c);
if (curl_errno($c) > 0) {
    print('Error calling PDFTables: '.curl_error($c).PHP_EOL);
} else {


  // save the CSV we got from PDFTables to a file
  file_put_contents ($pdf_file . ".csv", $result); // will write data to pdf file
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment;filename=".$pdf_file->getClientOriginalName().".csv");
 // make php send the generated csv lines to the browser
}
curl_close($c);

    }
}




