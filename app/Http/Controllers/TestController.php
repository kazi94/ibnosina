<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use App\Models\Appointement;
use App\Models\Patient;
use App\Models\Produitalimentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Excel;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use Debugbar;

class TestController extends Controller
{

    public function insertCnas()
    {

        set_time_limit(9999);

        $jsonString = file_get_contents(base_path('resources/lang/meds.json'));
        $data = json_decode($jsonString, true);

        //return $this->getSpWithoutDci();

        //return $this->checkPrefix($data);
        //$this->fileRead();
        return $this->showDcisEquiv($data);
        //DB::table('sp_specialite')->where('sp_algerie', '1')->delete();

        //$this->saveSpUnits($data);


        // $query="update sp_specialite set sp_dose=Replace(sp_dose, 'OU  ' , 'OU ')";
        // $query="update sp_specialite set sp_dose=Replace(sp_dose, ')' , '')";
        // $query="update sp_specialite set sp_dose=Replace(sp_dose, '(' , '')";
        // $query="update sp_specialite set sp_dose=Replace(sp_dose, '**' , '')";
        // $query="update sp_specialite set sp_dose=Replace(sp_dose, '**' , '')";

        //$this->getSp($data); // pour ajouter les sps qui nont pas d'unités dans la base de donnée 

    }
    private function showDcisEquiv($data)
    {
        $r1 = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->select('cosac_compo_subact.COSAC_SAC_CODE_FK_PK', DB::raw("GROUP_CONCAT(sac_subactive.SAC_NOM SEPARATOR ' / ') as sac"), 'sp_specialite.SP_NOM', 'sp_specialite.SP_CODE_SQ_PK')
            ->where('sp_algerie', '1')
            ->groupBy('sp_specialite.SP_CODE_SQ_PK')
            ->get();
        foreach ($r1 as $sp) {
            foreach ($data as $datas) {
                foreach ($datas as $alpha) {
                    if (!empty($alpha['Nom Commercial'])  && !empty($alpha['generic']) && !empty($alpha['Dosage'])) {
                        if ($sp->SP_NOM === $alpha['Nom Commercial'] . " " . $alpha['Dosage']) {
                            $generics = explode(' / ', $alpha['generic']);
                            // foreach ($generics as $gen) {
                            // if( $sp->SAC_NOM != $gen) {
                            if ($sp->sac != $alpha['generic']) {
                                //if( strpos($sp->SAC_NOM , $gen) === false) {
                                $r[] = array(
                                    'SP' => $sp->SP_CODE_SQ_PK,
                                    'SP nom' => $sp->SP_NOM,
                                    'Theriaque' => $sp->sac,
                                    'CNAS' => $alpha['generic'],
                                );
                            }
                            // }
                        }
                    }
                }
            }
        }
        return $r;
    }
    private function checkPrefix($data)
    {
        $dcis1 = DB::table('sac_subactive')->get();
        foreach ($dcis1 as $dci1) {
            $dcis2 = DB::table('sac_subactive')
                ->where('sac_subactive.SAC_CODE_SQ_PK', '!=', $dci1->SAC_CODE_SQ_PK)
                ->get();
            foreach ($dcis2 as $dci2) {
                $s = strpos($dci2->SAC_NOM, $dci1->SAC_NOM);
                if ($s !== false) { // dci1 verfie si il est contenu dans dc2 et retourne sa position
                    if (substr($dci2->SAC_NOM, 0, $s) != '') // si la position de dci1 par rapport au dci2 est 0 si qu'il n'as pas de préfixe
                    {
                        $r[] = array( // si diff ! 0 alrs il a un préfix
                            'sac 1' => $dci1->SAC_NOM,
                            'sac_code' => $dci1->SAC_CODE_SQ_PK,
                            'sac 2' => $dci2->SAC_NOM,
                        );
                    }
                }
            }
        }
        $sacs_code = collect($r)->map(function ($item, $key) {
            return $item->sac_code;
        });
        $r1 = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->whereIn('cosac_compo_subact.COSAC_SAC_CODE_FK_PK', $sacs_code)
            ->where('sp_algerie', '1')
            ->get();

        foreach ($data as $datas) {
            foreach ($datas as $alpha) {
                foreach ($r1 as $sp_th) {
                    if ($sp_th->SP_NOM === $alpha['Nom Commercial'] . " " . $alpha['Dosage']) {
                        $rs[] = array(
                            'theriaque' => $sp_th->SP_NOM . " ====> " . $sp_th->SAC_NOM,
                            'sp' => $alpha['Nom Commercial'] . " " . $alpha['Dosage'] . " ====> " . $alpha['generic'],
                        );
                        break;
                    }
                }
            }
        }
        return $rs;
    }


    private function getSp($data)
    {
        $compt = 0;
        $units = DB::table('unites')->get();
        $sps = DB::table('sp_specialite')
            ->whereIn('sp_specialite.sp_code_sq_pk', function ($query) {
                $query->select('pre_sp_code_fk')
                    ->from('pre_presentation');
            })
            ->get();
        foreach ($data as $datas) {
            foreach ($datas as $value) {
                if (!empty($value['Nom Commercial'])  && !empty($value['Forme'])) {
                    foreach ($sps as $sp) {
                        $alpha = $value['Nom Commercial'] . " " . $value['Dosage'];
                        if (strpos($value['Nom Commercial'], $sp->SP_NOM)) {
                            echo "sp bdd : {$sp->SP_NOM} ====> sp json : {$alpha} <BR/>";
                            // foreach ($units as $unit) {
                            //     if ($unit->unite_nom == $value['Forme']) {
                            //         DB::table('pre_presentation')->insert([
                            //         "pre_code_pk"        => $sp->SP_CODE_SQ_PK,
                            //         "pre_cdf_up_code_fk" => $unit->id,
                            //         "pre_sp_code_fk"     => $sp->SP_CODE_SQ_PK]);
                            //         break;
                            //     }
                            // }
                            echo $value['Forme'];
                            echo '<br/>';
                            $compt++;
                            break;
                        }
                    }
                }
            }
        }
        echo $compt;
    }

    private function getSpWithoutDci()
    {
        $resul = DB::select("select * from sp_specialite where sp_algerie='1' and sp_code_sq_pk not in (select distinct(sp_specialite.sp_code_sq_pk) from cosac_compo_subact, sp_specialite where cosac_compo_subact.COSAC_SP_CODE_FK_PK = sp_specialite.sp_code_sq_pk)", [1]);
        $jsonString = file_get_contents(base_path('resources/lang/meds.json'));
        $data = json_decode($jsonString, true);
        $dcis_bd = DB::table('sac_subactive')->get();
        $compt = 0;

        foreach ($data as $alphas) {
            foreach ($alphas as $alpha) // loop through medicaments rows.
            {
                if (!empty($alpha['Nom Commercial'])  && !empty($alpha['generic']) && !empty($alpha['Dosage'])) {

                    foreach ($resul as $sp) {
                        if ($sp->SP_NOM == $alpha['Nom Commercial'] . " " . $alpha['Dosage']) {
                            $compt++;
                            // Lier le médicament avec le DCI Theriaque  
                            $dcis_cnass = explode(' / ', $alpha['generic']); //generic :dci cnas
                            foreach ($dcis_cnass as $dci_cnass) {
                                $dci_cnas = " " . $dci_cnass;
                                foreach ($dcis_bd  as $dci_bd) {
                                    $dd = " " . $dci_bd->SAC_NOM;

                                    //if ($dci_cnas == $dd) // first if condition to execute
                                    if (strpos($dci_cnas, $dd) !== false)
                                    //if ( strpos($dd,$dci_cnas) !==false) 
                                    {
                                        $log[] = array(
                                            "DCI Theriaque : " => $dd,
                                            "DCI CNAS : "      => $dci_cnas,
                                        );
                                        //  if exist then set dci id with sp id in sac_subactive table
                                        $compt++;
                                        $dci_bd_id = $dci_bd->SAC_CODE_SQ_PK;
                                        // Ass id sp bb with dci id bdd in cosac compo subact
                                        try {
                                            //echo "<tr><td>".$dci_cnas ."</td><td>".$dd."</td></tr>";
                                            DB::table('cosac_compo_subact')->insert([
                                                "COSAC_SAC_CODE_FK_PK" => $dci_bd_id,
                                                "COSAC_SP_CODE_FK_PK"  => $sp->SP_CODE_SQ_PK,
                                                "COSAC_DOSAGE"         => $alpha['Dosage']
                                            ]);
                                        } catch (\Illuminate\Database\QueryException $e) {
                                            report($e);
                                            break;
                                        }
                                        break;
                                    }
                                }
                            }
                            $r[] = array(
                                'id' => $sp->SP_CODE_SQ_PK,
                                'medicament' => $sp->SP_NOM,
                                'dci' => $alpha['generic']
                            );
                        }
                    }
                }
            }
        }
        if (isset($log)) Debugbar::info($log);

        echo $compt;

        return view('admin.unite.create', compact('r'));
    }



    public function saveSpUnits($data)
    {
        $tab = array();
        $compt = 0;
        $compt_med = 0;
        $unites = DB::table('unites')->get();
        $dcis_bd = DB::table('sac_subactive')->get();
        foreach ($data as $alphas) {
            foreach ($alphas as $alpha) // loop through medicaments rows.
            {
                if (!empty($alpha['Nom Commercial'])  && !empty($alpha['generic']) && !empty($alpha['Dosage'])) {

                    $id = DB::table('sp_specialite')->insertGetId([
                        'SP_NOM' => $alpha['Nom Commercial'] . " " . $alpha['Dosage'],
                        'sp_algerie' => 1,
                        'sp_dose' => $alpha['Dosage'],
                        'SP_COPIE' => NULL
                    ]);

                    foreach ($unites as $unite) {
                        //\Log::info( "test unites {$unite->unite_nom} <br/>");
                        // echo 'forme : '.$alpha['Forme'].'<br/>';
                        // echo 'unite : '.$unite->unite_nom.'<br/>';
                        $forme = $alpha['Forme'];
                        if (strpos($forme, $unite->unite_nom) !== false) { // si la forme du json est contenu dans forme de bd

                            DB::table('pre_presentation')->insert([
                                "pre_code_pk"        => $id,
                                "pre_cdf_up_code_fk" => $unite->id,
                                "pre_sp_code_fk"     => $id
                            ]);
                            DB::table('spvo_specialite_voie')
                                ->insert([
                                    'spvo_specialite_voie.spvo_cdf_vo_code_fk_pk' => $unite->equiv,
                                    'spvo_specialite_voie.spvo_sp_code_fk_pk'    => $id
                                ]);
                            break 1;
                        }
                    }

                    // Lier le médicament avec le DCI Theriaque  
                    $dcis_cnass = explode(' / ', $alpha['generic']); //generic :dci cnas
                    foreach ($dcis_cnass as $dci_cnass) {
                        $dci_cnas = $dci_cnass;
                        foreach ($dcis_bd  as $dci_bd) {
                            $dd = $dci_bd->SAC_NOM;

                            // if ( strpos($dci_cnas , $dd) !==false|| strpos($dd, $dci_cnas) !==false) 
                            if ($dci_cnas == $dd) {
                                //  if exist then set dci id with sp id in sac_subactive table
                                $compt++;
                                $dci_bd_id = $dci_bd->SAC_CODE_SQ_PK;
                                // Ass id sp bb with dci id bdd in cosac compo subact
                                try {

                                    DB::table('cosac_compo_subact')->insert([
                                        "COSAC_SAC_CODE_FK_PK" => $dci_bd_id,
                                        "COSAC_SP_CODE_FK_PK"  => $id,
                                        "COSAC_DOSAGE"         => $alpha['Dosage']
                                    ]);
                                } catch (\Illuminate\Database\QueryException $e) {
                                    report($e);
                                    break;
                                }

                                break;
                            }
                        }
                    }
                }
            }
        }
        //echo $compt;
        $alg_specialites = DB::table('sp_specialite')->where('SP_ALGERIE', '1')->get();
        $specialites = DB::table('sp_specialite')->where('SP_ALGERIE', NULL)->get();

        foreach ($alg_specialites as $alg_sp) {
            foreach ($specialites as $sp) {
                if (strpos($sp->SP_NOM, $alg_sp->SP_NOM)) {

                    DB::table('sp_specialite')
                        ->where('SP_CODE_SQ_PK', $alg_sp->SP_CODE_SQ_PK)
                        ->update(['SP_COPIE' => 1]);
                    break;
                }
            }
        }
    }

    // public function fileRead()
    // {

    //     // Get all algeria specialite from DB
    //     //$alg_sps = DB::table('specialite')->where('sp_algeria','1')->get();

    //     // get all dcis from bd
    //     $dcis_bd = DB::table('sac_subactive')->get();

    //     // // Get sp and dcis from excel cnas
    //     // $dci_sp_cnas = $this->getFile();

    //     // foreach ($dci_sp_cnas->getRowIterator() as $row) {
    //     //     $cellIterator = $row->getCellIterator();
    //     //     $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
    //     //                                                        //    even if a cell value is not set.
    //     //                                                        // By default, only cells that have a value
    //     //                                                        //    set will be iterated.
    //     //     foreach ($cellIterator as $key => $cell) {
    //     //         // compare sp cnas with sp db
    //     //         if ($key == 'B') { // la colonne specialite
    //     //             foreach ($alg_sps as $sp_alg) {
    //     //                 if (strpos( $cell->getValue(), $sp_alg->SP_NOM )) { // si sp cnas est en partie contenu dans le nom sp bdd
    //     //                                                                     // exemple :
    //     //                                                                     //  sp_bdd = levothyrox 10mg
    //     //                                                                     //   sp_cnas = levothyrox
    //     //                                                                     //      
    //     //                     //  if exist then get dci of sp cnas
    //     //                      $dci_cnas = getDciCnas();
    //     //                     //  compare the name of dci cnas with dci bd
    //     //                     foreach ($dcis_bd  as $dci_bd) {
    //     //                         $dcis_cnas = explode("," , $dci_cnas)
    //     //                         foreach ($dcis_cnas as $dci_cnas) {
    //     //                             if ( strpos($dci_cnas , $dci_bd->nom) || strpos( $dci_bd->SAC_NOM, $dci_cnas) ) {
    //     //                                //  if exist then set dci id with sp id in sac_subactive table
    //     //                                $dci_bd_id = $dci_bd->SAC_CODE_SQ_PK
    //     //                                // Ass id sp bb with dci id bdd in cosac compo subact
    //     //                                 DB::table('cosac_compo_subact')->insert([
    //     //                                     "COSAC_SAC_CODE_FK_PK" => $dci_bd_id,
    //     //                                     "COSAC_SP_CODE_FK_PK" => $sp_alg->SP_CODE_SQ_PK]);
    //     //                                 }  
    //     //                             }                                     
    //     //                         }
    //     //                     }
    //     //                 }
    //     //             }
    //     //         }



    //     //         //  if not store the sp cnas in new xls file
    //     //         // if ($key == 'C' && $cell->getValue() != "DCI")

    //     //     }
    //     // }

    // }
    public function fileRead()
    {

        $cons = DB::table('consultations')->get();
        $signes = DB::table('signes')->get();

        foreach ($cons as $con) {
            $imp = explode(',', $con->signe);
            foreach ($imp as $k) {
                foreach ($signes as $sign) {
                    if ($sign->name == $k) {
                        DB::insert('insert into consultation_signe (consultation_id, signe_id) values (?, ?)', array($con->id, $sign->id));
                    }
                }
            }
        }

        // $plantes = $this->getFile();
        // for ($id = 2; $id < count($plantes); $id++) {
        //     if ($id == 97) {
        //         break;
        //     }
        //     $p = new Produitalimentaire;
        //     $p->famille = $plantes[$id]['D'];
        //     $p->produit_naturel_latin = $plantes[$id]['C'];
        //     $p->produit_naturel_fr = $plantes[$id]['B'];
        //     $p->produits_arabe =
        //         str_replace($plantes[$id]['A'], "،", ",");;
        //     $p->save();
        // }
    }

    private function getFile()
    {

        $inputFileType = 'Xlsx';
        $inputFileName = base_path('resources/lang/plantes.xlsx');

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
        /**  Load only the rows and columns that match our filter to Spreadsheet  **/

        // foreach ($worksheetData as $worksheet) {

        //     $sheetName = $worksheet['worksheetName'];

        //     //echo "<h4>$sheetName</h4>";
        //     /**  Load $inputFileName to a Spreadsheet Object  **/
        //     $reader->setLoadSheetsOnly($sheetName);
        //     $spreadsheet = $reader->load($inputFileName);

        //     $worksheet = $spreadsheet->getActiveSheet();
        //     $rows = $worksheet->toArray();
        //     return $rows;
        // }
    }
}


/**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {
        //  Read rows 1 to 7 and columns A to E only
        if ($row >= 1 && $row <= 2) {
            if (in_array($column, range('A', 'B'))) {
                return true;
            }
        }
        return false;
    }
}
