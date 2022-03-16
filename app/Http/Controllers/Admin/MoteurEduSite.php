<?php

namespace App\Http\Controllers\Admin;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

use App\Http\Controllers\Controller;

use App\Models\Education;
use DB;


class MoteurEduSite extends Controller
{
    function analyser($pathologie, $observance, $medicament_dci)
    {
        //echo $pathologie;
        session_start();
        $si = "";
        $titre = "";
        $commentaire = "";
        $maladie = "";
        $effet = "";
        $voyage = "";
        $act = "";
        $utilisation = "";
        $effet_indiserable = "";
        $regime = "";
        $url = "";
        $pdf = "";

        //recuperer les regles de l'éducation thérapeutique
        $educations = Education::all();

        $c = 0;
        $alert2 = "";
        $resultatAnalyse[] = "";
        foreach ($educations as $education) {
            $_SESSION['conditionET'] = 0;
            $alert2 = $this->analyseTherapeutique($education->si, $pathologie, $observance, $medicament_dci);
            //echo "!!!!!!".$alert2;
            if ($_SESSION['conditionET'] == 1) {
                if (strchr($alert2, "0") != null) {
                    $resultatAnalyse[$c] = 0;
                } else {
                    $resultatAnalyse[$c] = 1;
                }
            } else {
                if (strchr($alert2, "1")) {
                    $resultatAnalyse[$c] = 1;
                } else $resultatAnalyse[$c] = 0;
            }

            if ($resultatAnalyse[$c] == 1) {

                return $education->id;
            }
            $c++;
        }
        return -1;
    }
    function analyseTherapeutique($regle, $pathologie, $observance, $medicament_dci)
    {
        //echo $regle;
        $elements_regle = explode(" ", $regle);
        $result = "";
        $pathologies_patient[1] = str_replace(' ', '', $pathologie);
        $medicament_array[1] = str_replace(' ', '', $medicament_dci);
        $observation_patient = $observance;
        //    echo $elements_regle[0];
        //echo $pathologies_patient[1]."--".$medicament_array[1]."---".$observation_patient.'------';
        switch ($elements_regle[0]) {

            case "pathologie":

                $et = false;
                $condition_pathologie = "";
                $pathologies_regle[] = "";
                if ($elements_regle[2] == "{") {
                    for ($x = 3; $x < count($elements_regle); $x++) {
                        $condition_pathologie = $condition_pathologie . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                    if (strchr($condition_pathologie, ",")) {
                        $et = true;
                        $pathologies_regle = explode(",", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else if (strchr($condition_pathologie, "/")) {
                        $pathologies_regle = explode("/", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $pathologies_regle = trim($condition_pathologie, $elements_regle[$x]);
                    if (is_array($pathologies_regle) == false) {
                        $pathologies_regle = str_split($pathologies_regle, strlen($pathologies_regle));
                    }
                    for ($y = 0; $y < count($pathologies_regle); $y++) {
                        $pathologies_regle[$y] = str_replace(' ', '', $pathologies_regle[$y]);
                        $pos = array_search($pathologies_regle[$y], $pathologies_patient);
                        if ($pos != false) {
                            //  echo "OK";
                            $condition[$y] = 1;
                        } else $condition[$y] = 0;
                    }
                } else {
                    $pathologies_regle = $elements_regle[2];
                    $pos = array_search($pathologies_regle, $pathologies_patient);
                    if ($pos != false) {
                        $condition[0] = 1;
                    } else $condition[0] = 0;
                }
                if ($et) {
                    for ($x = 0; $x < count($condition); $x++) {
                        if ($condition[$x] == 0) {
                            $result = 0;
                            break;
                        }
                    }
                    if ($x == count($condition)) $result = 1;
                } else {
                    for ($x = 0; $x < count($condition); $x++) {
                        if ($condition[$x] == 1) {
                            $result = 1;
                            break;
                        }
                    }
                    if ($result == 1) $result = 1;
                    else $result = 0;
                }

                //echo "---------------".$result;
                //echo "pat".$pathologies_patient[1].'--'.$pathologies_regle[0].'-->'.$result;
                break;


            case "médicament":
                //recuperer le nom du medicament ainsi que la dose journaliere dans la regle
                $condition[] = "";
                $condition_med = "";
                $et = false;
                $med_dos_regle[] = "";
                if ($elements_regle[2] == "{") {
                    for ($x = 3; $x < count($elements_regle); $x++) {
                        $condition_med = $condition_med . " " . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                }
                if (strchr($condition_med, ";")) {
                    $et = true;
                    // return "okk";
                    $med_dos_regle = explode(";", trim($condition_med, $elements_regle[$x]));
                } else if (strchr($condition_med, "/"))
                    $med_dos_regle = explode("/", trim($condition_med, $elements_regle[$x]));


                else $med_dos_regle = trim($condition_med, $elements_regle[$x]);
                // $med_dos_regle = explode(",",$condition_med);
                $medicaments_regle[] = "";
                $dosages_regle[] = "";
                if (is_array($med_dos_regle) == false) {
                    $med_dos_regle = str_split($med_dos_regle, strlen($med_dos_regle));
                }
                for ($x = 0; $x < count($med_dos_regle); $x++) {
                    $medicaments_regle[$x] = str_replace(' ', '', $med_dos_regle[$x]);
                    $pos = array_search($medicaments_regle[$x], $medicament_array);
                    if ($pos != false) {
                        $condition[$x] = 1;
                    } else $condition[$x] = 0;
                }

                if ($et) {
                    if (count($condition) != count($medicaments_regle)) $result = 0;
                    else {
                        for ($x = 0; $x < count($condition); $x++) {
                            if ($condition[$x] == 0) {
                                $result = 0;
                                break;
                            }
                        }
                        if ($x == count($condition)) $result = 1;
                    }
                } else {
                    for ($x = 0; $x < count($condition); $x++) {
                        if ($condition[$x] == 1) {
                            $result = 1;
                            break;
                        }
                    }
                    if ($result == 1) $result = 1;
                    else $result = 0;
                }
                //echo $result;
                //return "meed".$medicaments_regle[0]."--".$medicament_array[1]."-->".$result;
                break;







            default:

                if ($observation_patient == null) {
                    $result = 0;
                } else if (strchr($regle, $observation_patient)) $result = 1;
                else $result = 0;
                //return $observation_patient."->".$result;
        }
        if ($elements_regle[0] == "médicament" || $elements_regle[0] == "pathologie") {
            $x = 0;
            $chaine_a_supp = "";
            $taille_regle = count($elements_regle);
            while ($elements_regle[$x] != "}") {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                $x++;
            }
            if ($x != ($taille_regle - 1)) {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x] . " " . $elements_regle[$x + 1] . " ";
                $regle = strstr($regle, $elements_regle[($x + 1)] . " ");
                $regle = ltrim($regle, $elements_regle[($x + 1)] . " ");
                //return $regle;
                //return strstr($regle,$elements_regle[($x+1)]." ");
                //return ltrim($regle,$elements_regle[($x)]." ");
                if ($elements_regle[($x + 1)] == "ET") $_SESSION['conditionET']  = 1;
            } else {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                //return $regle;
                $regle = strstr($regle, $elements_regle[$x]);
                $regle = ltrim($regle, $elements_regle[$x]);
            }
            //return $regle;
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseTherapeutique($regle, $pathologie, $observance, $medicament_dci);
            }
        } else {

            $chaine_a_supp = "";
            $x = 0;
            if (in_array("ET", $elements_regle)) {
                while ($elements_regle[$x] != "ET" && $x != (count($elements_regle) - 1)) {
                    $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                    $x++;
                }
            } else {
                while ($elements_regle[$x] != "OU" && $x != (count($elements_regle) - 1)) {
                    $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                    $x++;
                }
            }
            if ($elements_regle[$x] == "ET") $_SESSION['conditionET']  = 1;
            $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x] . " ";
            // return "!!".$regle;
            $regle = strstr($regle, $elements_regle[$x] . " ");

            $regle = ltrim($regle, $elements_regle[$x] . " ");
            //echo $regle."".$pathologie." ".$observance." ".$medicament_dci;
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseTherapeutique($regle, $pathologie, $observance, $medicament_dci);
            }
        }
    }
}
