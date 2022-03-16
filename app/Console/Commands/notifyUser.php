<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\RegleSuivPatient;
use App\Models\Suivi;
use Nexmo\Laravel\Facade\Nexmo;
use DB;



class notifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notifier le medecin en cas où le patient a besoin d une éducation thérapeutique';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //recuperer tous les patients
        $patients = Patient::all();

        //recuperer les regles de l'éducation thérapeutique
        $regleesSuivis = Suivi::all(); 

        session_start();

        $_SESSION['conditionET'] = 0;
       
        $c = 0; $o = 0;
        $condition = 0;
        $resultatAnalyse[] ="";
        $alert2[] = "";
        $alors[] =""; $commentraire[]=""; $si[]="";
  
    
        foreach($patients as $patient){
            $prescrip_id =DB::select("select `prescriptions`.`id` from `prescriptions` where `patient_id`=".$patient->id." ORDER BY `date_prescription` DESC LIMIT 1");
            $prescription="";
            foreach($prescrip_id as $i =>$prescrip_id)
              $prescription = Prescription::find($prescrip_id->id);
            foreach($regleesSuivis as $reglee){
               $_SESSION['valeursDeclenchantes']="";
               $_SESSION['conditionET'] = 0;
               
                $alert2 = self::analyseSuivie($reglee->si , $patient , $prescription);
                if($_SESSION['conditionET'] == 1){
                    if(strchr($alert2,"0")!=null) $resultatAnalyse[$c] = 0;
                    else {
                        $resultatAnalyse[$c] = 1;
                    }
                }
                else {
                    if(strchr($alert2,"1")) {
                        $resultatAnalyse[$c] = 1;
                    }
                    else $resultatAnalyse[$c] = 0;
                }
              // if($reglee->id == 10)$this->info($_SESSION['valeursDeclenchantes']."---".$alert2);

               if($resultatAnalyse[$c] == 1){
                    $regl= RegleSuivPatient::where(['patient_id' => $patient->id,'regle_id' => $reglee->id])->first();   
                    if($regl != null){}else{
                    $suiv_regle_pres = new RegleSuivPatient();
                    $suiv_regle_pres->patient_id = $patient->id;
                    $suiv_regle_pres->regle_id = $reglee->id;
                    $suiv_regle_pres->valeursDeclenchantes = $_SESSION['valeursDeclenchantes'];
                    $suiv_regle_pres->save();
                    if($reglee->envoie != ""){
                       // $this->info($prescription->prescripteur->telephone);
                        $tel =$prescription->prescripteur->telephone;
                        if($reglee->niveau==1){
                            if(strchr($reglee->envoie,"sms")){
                                $this->info("dkhelna");
                               /* Nexmo::message()->send([
                                    'to'   => $tel,
                                    'from' => 'NEXMO',
                                    'text' => 'attention pour ce patient'
                                ]);
                                Session::flash('success','SMS a été bien envoyé au '.$prescription->prescripteur->telephone);
                                //return 
                                if(Session::has('success')) $this->info(Session('success'));*/
                            
                            }
                        }
                    }
                    
                }
                }
                $c++;
            
            }
        }
        $this->info('L analyse de suivie a été faite !');
    }
     //cette fonction c'est le moteur de recherche pour l'editeur de regle de l'analyse de suivie 
    protected function analyseSuivie($regle , $patient , $prescription)
     {
        $liste_examens_req =  DB::select("select element from elements");
        $elements_regle = explode(" ",$regle);
       // return $elements_regle[0];

        $liste_examens[]="";
        $n = 0;$result="";
        foreach($liste_examens_req as $list =>$liste_examens_req){
            $liste_examens[$n] = $liste_examens_req->element;
            $n++;
        } 
        //comparer le suivi par rapport au porcentage
         $pourcentage =20;
       
        
        
        //if($liste_examens[$pos_ex]=="Poids") $elements_regle[0]= "Poids";
         switch ($elements_regle[0]) {
             case "Poids(kg)":
                    $poids_result =  DB::select("select element,valeur,date_analyse from bilans,elements where element = 'Poids' and bilans.element_id = elements.id and bilans.patient_id=".$patient->id." ORDER BY bilans.date_analyse DESC LIMIT 2");
                    $n=1;
                    $valeur[]=""; $valeur_examen2="";
                    foreach($poids_result as $poid => $poids_result){
                        $valeur[$n]=$poids_result->valeur;
                        $n++;
                    }
                    
                    if($elements_regle[1]=="à" && $elements_regle[2]=="la" ){
                      
                            if($n>2){
                                if($elements_regle[3]=="hausse"){
                                    //if($valeur[1]>$valeur[2]) $result = 1; 
                                    if(((($valeur[1]-$valeur[2])/$valeur[2])*100) >= $pourcentage ) $result = 1;
                                    else $result = 0;
                                }else {
                                    //if($valeur[1]<$valeur[2]) $result = 1; 
                                    if(((($valeur[1]-$valeur[2])/$valeur[2])*100) <= ($pourcentage*-1) ) $result = 1;
                                    else $result = 0;
                                }
                            }else if($n==2){
                                if($elements_regle[3]=="hausse"){
                                    if(((($valeur[1]-$patient->poids)/$patient->poids)*100) >= $pourcentage ) $result = 1;
                                    //if($valeur[1]> $patient->poids) $result = 1; 
                                    else $result = 0;
                                }else {
                                    if(((($valeur[1]-$patient->poids)/$patient->poids)*100) <= ($pourcentage*-1) ) $result = 1;
                                    //if($valeur[1]< $patient->poids) $result = 1; 
                                    else $result = 0;
                                }
                            }else $result = 0;
                   
                        if($result==1) {
                           if($n>2) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."Poids : ancienne valeur =".$valeur[2]." et valeur actuelle =".$valeur[1]."\n";
                           if($n==2)$_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."Poids : ancienne valeur =".$patient->poids." et valeur actuelle =".$valeur[1]."\n";
                        }

                    }else{
                        if($n>2){
                            $poids_patient = $valeur[1];
                        }else  $poids_patient = $patient->poids;
                        $operation = $elements_regle[1];
                        $poids_regle = $elements_regle[2];            
                        if($operation == "="){  
                            if($poids_patient == $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == "<="){
                            if($poids_patient <= $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == ">="){
                            if($poids_patient >= $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == "!="){
                            if($poids_patient != $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == ">"){
                            if($poids_patient > $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == "<"){
                            if($poids_patient < $poids_regle) $result = 1;
                            else  $result=0;
                        }else if($operation == "+" || $operation == "-" || $operation == "/" || $operation == "*"){
                            $valeur_examen2="";
                            $k=2; //return $elements_regle[$k];
                            //return $regle;
                            $examen_nom_unite="";$examen_nom="";
                            while(substr($elements_regle[$k], 0, 1) !="("){
                                $examen_nom = $examen_nom." ".$elements_regle[$k];  
                                $k++;
                                }
                                $examen_nom_unite = $examen_nom." ".$elements_regle[$k];
                                // echo $examen_nom_unite;
                                    //return $examen_nom_unite;
                                $pos_ex = array_search($examen_nom_unite,$liste_examens);
                                if($pos_ex ==false){
                                    for($y=0 ; $y < count($liste_examens) ; $y++){
                                        $liste_examens[$y]=strtolower($liste_examens[$y]);
                                    }
                                    $pos_ex = array_search($examen_nom_unite,$liste_examens);
                                }
                                //return "--".$regle;
                                //supprimer le premier espace ;
                                $examen_nom=ltrim($examen_nom," ");
                               // return "--".$examen_nom."--".trim($elements_regle[$v],"()");
                                $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='".$examen_nom."' and unite ='".trim($elements_regle[$k],"()")."' and bilans.element_id = elements.id and bilans.patient_id=".$patient->id." ORDER BY bilans.date_analyse DESC LIMIT 1");
                                foreach($examens as $examen => $examens){
                                $valeur_examen2 = $examens->valeur;
                                }
                               // return $valeur_examen2;
                            if($valeur_examen != null && $valeur_examen2 != null){
                                if($operation == "+"){  
                                   // return $valeur_examen."((".$valeur_examen2;
                                    $result_opertation = $valeur_examen + $valeur_examen2;
                                }else if($operation == "-"){
                                    $result_opertation = $valeur_examen - $valeur_examen2;
                                }else if($operation == "/"){
                                    $result_opertation = $valeur_examen / $valeur_examen2;
                                }else if($operation == "*"){
                                    $result_opertation = $valeur_examen * $valeur_examen2;
                                }

                                if($elements_regle[$k+1] == "="){  
                                    if($elements_regle[$k+2] == $result_opertation) $result = 1;
                                    else  $result=0;
                                }else if($elements_regle[$k+1] == "<="){
                                    if($result_opertation <= $elements_regle[$k+2]) $result = 1;
                                    else  $result=0;
                                }else if($elements_regle[$k+1] == ">="){
                                    if($result_opertation >= $elements_regle[$k+2]) $result = 1;
                                    else  $result=0;
                                }else if($elements_regle[$k+1] == "!="){
                                    if($result_opertation != $elements_regle[$k+2]) $result = 1;
                                    else  $result=0;
                                }else if($elements_regle[$k+1] == ">"){
                                    if($result_opertation > $elements_regle[$k+2]) $result = 1;
                                    else  $result=0;
                                }else if($elements_regle[$k+1] == "<"){
                                    if($result_opertation < $elements_regle[$k+2]) $result = 1;
                                    else  $result=0;
                                }
                            }else $result =0;
                            //return $valeur_examen.$operation.$valeur_examen2."=".$result_opertation.$elements_regle[$k+1].$elements_regle[$k+2]."--->".$result;
                        }
                   
                       // return $poids_patient;
                        if($result==1){
                           // return $_SESSION['valeursDeclenchantes'];
                            if($valeur_examen2 != "") $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."poids = ".$poids_patient."\n".$examen_nom." =".$valeur_examen2."\n";
                            else $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."poids = ".$poids_patient."\n";
                        } 
                    }
                   
                //return $poids_patient.$operation.$poids_regle."=".$result;
             break;
             case "Pathologie(s)":
                     $pathologies_patient[] = "";
                     $n=1;$valeurs_verifiees="";
                     $pathologies_patient[1]="rien";
                     $pathologies =  DB::select("select distinct pathologie from  pathologies,pathologie_patient where pathologies.id = pathologie_patient.pathologie_id and patient_id=".$patient->id);
                     foreach($pathologies as $pat => $pathologies){
                         $pathologies_patient[$n] =str_replace(' ','',$pathologies->pathologie);
                         $n++;
                     }
                     $et=false;
                     $condition_pathologie ="";
                     $pathologies_regle[]="";
                     if($elements_regle[3]=="{"){
                         for($x=4;$x<count($elements_regle);$x++){
                             $condition_pathologie = $condition_pathologie." ".$elements_regle[$x];
                             if($elements_regle[$x] == "}") break;
                           }
                         if(strchr($condition_pathologie,";")){
                             $et=true;
                             $pathologies_regle = explode(";", trim($condition_pathologie,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                         }else   
                             $pathologies_regle = explode("/", trim($condition_pathologie,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                            
                         for ($y = 0; $y < count($pathologies_regle); $y++){
                             $pathologies_regle[$y] = str_replace(' ','',$pathologies_regle[$y]);
                             $pos=array_search($pathologies_regle[$y],$pathologies_patient);
                                 if($pos != false){
                                    //return $pathologies_patient[$pos];
                                     $condition[$y] = 1;
                                     $valeurs_verifiees=$valeurs_verifiees." ".$pathologies_patient[$pos];
                                 }else $condition[$y] = 0;
                         }
                     }else{
                         $pathologies_regle =$elements_regle[3];
                         $pos=array_search($pathologies_regle,$pathologies_patient);
                         if($pos != false){
                             $condition[0] = 1;
                             $valeurs_verifiees=$elements_regle[3];
                         }else $condition[0] = 0;
                     }
                     if($et){
                         for($x = 0 ; $x < count($condition) ; $x++){
                             if($condition[$x]==0){ $result = 0 ; break;}
                         }
                         if($x == count($condition)) $result = 1;
                     }else{
                         for($x = 0 ; $x < count($condition) ; $x++){
                             if($condition[$x]==1){ $result = 1 ; break;}
                         }
                         if($result==1) $result = 1;
                         else $result = 0;
                     }
                     //return "path".$pathologies_patient[1]."--".$pathologies_regle[0]." ".$pathologies_regle[1]."-->".$result;
                     if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."pathologie(s) = ".$valeurs_verifiees."\n";
                 break;
                 case "Allergie(s)":
                     //return "ok";
                     $allegries_patient[] = "";
                     $n=1;$valeurs_verifiees="";
                     $allegries =  DB::select("select distinct allergie from  allergies,allergie_patient where allergies.id = allergie_patient.allergie_id and patient_id=".$patient->id);
                     foreach($allegries as $alr => $allegries){
                         $allegries_patient[$n] = str_replace(' ','',$allegries->allergie);
                         $n++;
                     }
                     $condition_allergie ="";
                     $allegries_regle[]="";
                     $et =false;
                     if($elements_regle[3]=="{"){
                         for($x=4;$x<count($elements_regle);$x++){
                             $condition_allergie = $condition_allergie.$elements_regle[$x];
                             if($elements_regle[$x] == "}") break;
                           }
                         if(strchr($condition_allergie,";")){
                             $et=true;
                             $allegries_regle = explode(";", trim($condition_allergie,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                         }else   
                             $allegries_regle = explode("/", trim($condition_allergie,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                         for ($y = 0; $y < count($allegries_regle); $y++){
                             $allegries_regle[$y] = str_replace(' ','',$allegries_regle[$y]);
                             $pos=array_search($allegries_regle[$y],$allegries_patient);
                             if($pos != false){
                                $condition[$y] = 1;
                                $valeurs_verifiees=$valeurs_verifiees." ".$allegries_patient[$pos];
                             }else $condition[$y] = 0;
                         }  
                     }else{
                         $allegries_regle =$elements_regle[3];
                         $pos=array_search($allegries_regle,$allegries_patient);
                         if($pos != false){
                             $condition[0] = 1;
                             $valeurs_verifiees=$elements_regle[3];
                         }else $condition[0] = 0;
                     }
                     if($et){
                         for($x = 0 ; $x < count($condition) ; $x++){
                             if($condition[$x]==0){ $result = 0 ; break;}
                         }
                         if($x == count($condition)) $result = 1;
                     }else{
                         for($x = 0 ; $x < count($condition) ; $x++){
                             if($condition[$x]==1){ $result = 1 ; break;}
                         }
                         if($result==1) $result = 1;
                         else $result = 0;
                     }
                     if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."allergie(s) = ".$valeurs_verifiees."\n";
                     //return "alergi".$allegries_patient[0]."--".$allegries_regle[0].$allegries_regle[1]."-->".$result;
                 break;
                 
                 case "Service":
                    $hospitalisations =  DB::select("select service from hospitalisations where patient_id =".$patient->id." order by date_admission DESC");
                    $operation = $elements_regle[1];
                    $x =2; $service_regle="";$service_patient="";

                    while($elements_regle[$x] != "ET" && $elements_regle[$x] != "OU" && $x != (count($elements_regle)-1) )
                        $service_regle =$service_regle.$elements_regle[$x];
                    
                    foreach($hospitalisations as $hosp => $hospitalisations){
                        $service_patient =  $hospitalisations->service;
                    }
                    $service_regle =str_replace(' ','',$service_regle);
                    $service_patient =str_replace(' ','',$service_patient);
                    if($service_patient == $service_regle) $result = 1;
                    else $result = 0;
            
                    if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."service = ".$service_patient."\n";
                    //return $service_patient."--".$service_regle."-->".$result;
                 break;
                 case "Durée":
                     $operation = $elements_regle[2];
                     $dureeHos_regle =$elements_regle[3];
                     //$unite_hos = $elements_regle[4];
                     $dureeHos_patient="";
         
                     $hospitalisations =  DB::select("select date_admission,date_sortie from  hospitalisations where patient_id =".$patient->id." order by date_admission DESC");
                     foreach($hospitalisations as $hosp => $hospitalisations){
                         $debut = date_create( $hospitalisations->date_admission);
                         $fin = date_create( $hospitalisations->date_sortie );
                         $date_interval = date_diff( $fin, $debut );
                         $dureeHos_patient = $date_interval->format('%d');
                     }
                     if($operation == "="){  
                         if($dureeHos_patient == $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }else if($operation == "<="){
                         if($dureeHos_patient <= $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }else if($operation == ">="){
                         if($dureeHos_patient >= $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }else if($operation == "!="){
                         if($dureeHos_patient != $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }else if($operation == ">"){
                         if($dureeHos_patient > $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }else if($operation == "<"){
                         if($dureeHos_patient < $dureeHos_regle) $result = 1;
                         else  $result=0;
                     }        
                     if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."durée hospitalisation = ".$dureeHos_patient."jours \n";        
                 break;
                 case "Produits" :
                 //return "bbbbbbbbb";
                     $phyto_resultat =DB::select("select produitalimentaires.produit_naturel_fr,frequence,frequence_date from phytotherapies,produitalimentaires where phytotherapies.patient_id=".$patient->id." and produitalimentaires.id=phytotherapies.produitalimentaire_id and phytotherapies.date_phyto = '".$prescription->date_prescription."'");
                     $phyto_prescri[]="";$frequence[]="";$frequence_date[]="";
                     $l=1;$n=0; 
                     $et = false;
                     foreach($phyto_resultat as $phy => $phyto_resultat){
                         $phyto_prescri[$l] =str_replace(' ','',$phyto_resultat->produit_naturel_fr);
                         $frequence[$n] = $phyto_resultat->frequence;
                         if($phyto_resultat->frequence_date != null) {
                             $frequence_date[$n] = $phyto_resultat->frequence_date;
                         }
                         $l++;
                         $n++;
                     }
                     $condition_phyto ="";
                     $condition[]="";$valeurs_verifiees="";
                     if($elements_regle[3]=="{"){
                         for($x=4;$x<count($elements_regle);$x++){
                             if($elements_regle[$x] == "}") break;
                             $condition_phyto = $condition_phyto." ".$elements_regle[$x];
                             
                             }
                         if(strchr($condition_phyto,";")){
                             $et=true;
                             $phyto_regle = explode(";", trim($condition_phyto,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                         }else   
                             $phyto_regle = explode("/", trim($condition_phyto,$elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                         //return "cccccccccccc".$phyto_regle[0]."!!--".$phyto_regle[1]."**".count($phyto_regle);
                         for ($y = 0; $y < count($phyto_regle) ; $y++){
                             if(strchr($phyto_regle[$y],"Occasionnellement")){
                                 $frequence_regle = "Occasionnellement";
                                 $phyto_regle[$y] = strstr($phyto_regle[$y],"Occasionnellement",1);
                                 $phyto_regle[$y] = str_replace(' ','',$phyto_regle[$y]);
                                 $pos=array_search($phyto_regle[$y],$phyto_prescri);
                                     if($pos != false){
                                         if($frequence[$y] == "Occasionnellement") {
                                             $condition[$y] = 1;
                                             $valeurs_verifiees=$valeurs_verifiees." ".$phyto_prescri[$pos];
                                            }
                                         else $condition[$y] = 0;
                                     }
                             }
                             if(strchr($phyto_regle[$y],"Exceptionnellement")){
                                 $frequence_regle = "Exceptionnellement";
                                 $phyto_regle[$y] = strstr($phyto_regle[$y],"Exceptionnellement",1);
                                 $phyto_regle[$y] = str_replace(' ','',$phyto_regle[$y]);
                                 $pos=array_search($phyto_regle[$y],$phyto_prescri);
                                     if($pos != false){
                                         if($frequence[$y] == "Exceptionnellement") {
                                            $condition[$y] = 1;
                                            $valeurs_verifiees=$valeurs_verifiees." ".$phyto_prescri[$pos];
                                           }
                                         else $condition[$y] = 0;
                                     }
                             }
                             if(strchr($phyto_regle[$y],"Depuis(jours)")){
                                 $frequence_regle = "Depuis(jours)";
                                 $frequence_jours = filter_var($phyto_regle[$y], FILTER_SANITIZE_NUMBER_INT);
                                 $phyto_regle[$y] = strstr($phyto_regle[$y],"Depuis(jours)",1);
                                 $phyto_regle[$y] = str_replace(' ','',$phyto_regle[$y]);
                                 $pos=array_search($phyto_regle[$y],$phyto_prescri);
                                 $jour_freq=0;
                                     if($pos != false){
                                         if($frequence[$y] == "Depuis :"){
                                             $datetime1 = date_create($frequence_date[$y]);
                                             $datetime2 = date_create(date('Y-m-d',strtotime("now")));
                                             $interval = date_diff($datetime1, $datetime2);
                                             $jour_freq = $interval->format('%d');                                           
                                             if($jour_freq == $frequence_jours) {
                                                $condition[$y] = 1;
                                                $valeurs_verifiees=$valeurs_verifiees." ".$phyto_prescri[$pos];
                                               }
                                             else $condition[$y] = 0;
                                         }
                                         else $condition[$y] = 0;
                                     }
                             }
                         } 
                     }
                     if($et){
                         if(count($condition)!=count($phyto_regle)) $result =0;
                         else{
                             for($x = 0 ; $x < count($condition) ; $x++){
                                 if($condition[$x]==0){ $result = 0 ; break;}
                             }
                             if($x == count($condition)) $result = 1;
                         }
                     }else{
                         for($x = 0 ; $x < count($condition) ; $x++){
                             if($condition[$x]==1){ $result = 1 ; break;}
                         }
                         if($result==1) $result = 1;
                         else $result = 0;
                     }   
                     if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."produit(s) alimentaire(s) = ".$valeurs_verifiees."\n"; 
                 break;
                 case "Médicament":
                     //recuperer le nom du medicament ainsi que la dose journaliere dans la prescription
                     $medicament_array[]="";
                     $dosage_array[]="";
                     $l=1;
                     if($prescription != null){
                        foreach ($prescription->lignes as $ligne){
                            $medicament_resultat =DB::select("select SP_NOM from  sp_specialite where SP_CODE_SQ_PK =".$ligne->med_sp_id);
                            $dosage_array[$l] = $ligne->dose_matin + $ligne->dose_midi + $ligne->dose_soir+ $ligne->dose_avant_coucher;
                            $medicament_prescri="";
                            foreach($medicament_resultat as $med => $medicament_resultat){
                                $medicament_prescri =$medicament_resultat->SP_NOM;
                            }
                            $medicament_array[$l]=str_replace(' ','',$medicament_prescri);
                            $l++;
                        }
    
                        //recuperer le nom du medicament ainsi que la dose journaliere dans la regle
                        $condition[]="";
                        $condition_med="";
                        $et=false;
                        if($elements_regle[2]=="{"){
                            for($x=3;$x<count($elements_regle);$x++){
                                $condition_med = $condition_med." ".$elements_regle[$x];
                                if($elements_regle[$x] == "}") break;
                                }}
                        if(strchr($condition_med,";")){
                                $et=true;
                                // return "okk";
                                    $med_dos_regle = explode(";",trim($condition_med,$elements_regle[$x]));
                        }else if(strchr($condition_med,"/"))  
                        $med_dos_regle = explode("/",trim($condition_med,$elements_regle[$x]));
                        // return $med_dos_regle[0]." ".$med_dos_regle[1]." ".$med_dos_regle[2]." ";
                        else $med_dos_regle = trim($condition_med,$elements_regle[$x]);
                        // $med_dos_regle = explode(",",$condition_med);
                        if(is_array($med_dos_regle)==false){
                            $med_dos_regle =str_split($med_dos_regle,strlen($med_dos_regle));
                        }
                        // $med_dos_regle = explode(",",$condition_med);
                        $medicaments_regle[]="";
                        $dosages_regle[]="";$valeurs_verifiees="";
                        for($x=0 ; $x < count($med_dos_regle) ;$x++){
                            $med_regle = explode(" ", $med_dos_regle[$x]);
                            $medicament_nom="";
                            $k=0;
                            //return $med_dos_regle[0].$med_dos_regle[1].$med_dos_regle[2];
                            while($med_regle[$k] != "["){
                                $medicament_nom = $medicament_nom." ".$med_regle[$k];  
                                $k++;
                            }
                            // supprimer les espace de la chaine de caractere pour faciliter la comparaison.
                            $medicaments_regle[$x]=str_replace(' ','',$medicament_nom);
                            if($med_regle[$k+1] != " ")
                                $dosages_regle[$x]=$med_regle[$k+1];
                            else $dosages_regle = 0;
                        }
                        for ($y = 0; $y < count($medicaments_regle); $y++){
                            $pos=array_search($medicaments_regle[$y],$medicament_array);
                                if($pos != false){
                                    if($dosages_regle[$y] != 0){
                                            if($dosages_regle[$y] == $dosage_array[$pos]."ParJour"){
                                                $condition[$y]=1;
                                                $valeurs_verifiees=$valeurs_verifiees." ".$medicament_array[$pos];                                
                                            }else {$condition[$y]=0;}
                                    }else{
                                        $condition[$y]=1;
                                        $valeurs_verifiees=$valeurs_verifiees." ".$medicament_array[$pos];
                                    }
                                }
                        }
                        if($et){
                            if(count($condition)!=count($medicaments_regle)) $result =0;
                            else{
                                for($x = 0 ; $x < count($condition) ; $x++){
                                    if($condition[$x]==0){ $result = 0 ; break;}
                                }
                                if($x == count($condition)) $result = 1;
                            }
                        }else{
                            for($x = 0 ; $x < count($condition) ; $x++){
                                if($condition[$x]==1){ $result = 1 ; break;}
                            }
                            if($result==1) $result = 1;
                            else $result = 0;
                        }
                    }else $result = 0;
                    if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes']."Médicament = ".$valeurs_verifiees."\n"; 
                     //return $medicaments_regle[0]."--".$medicament_array[1]."-->".$result;
                 break;
                 default:
                    $valeur_examen=""; $examen_nom="";$examen_nom_unite="";
                    $v=0;
                   // $this->info($regle);
                    while(substr($elements_regle[$v], 0, 1) != "("){
                        $examen_nom = $examen_nom." ".$elements_regle[$v];
                        $v++;
                    }
                    
                    $examen_nom_unite = $examen_nom." ".$elements_regle[$v];
                  
                    $pos_ex = array_search($examen_nom_unite,$liste_examens);
                    if($pos_ex ==false){
                        for($y=0 ; $y < count($liste_examens) ; $y++){
                            $liste_examens[$y]=strtolower($liste_examens[$y]);
                        }
                        $pos_ex = array_search($examen_nom_unite,$liste_examens);
                    }
                 
                    $examen_nom=ltrim($examen_nom," ");
                 
                    $valeur_examen2="";
                   if(strchr($regle,"hausse") || strchr($regle,"baisse")){
                         $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='".$examen_nom."' and unite ='".trim($elements_regle[$v],"()")."' and bilans.element_id = elements.id and bilans.patient_id=".$patient->id." ORDER BY bilans.date_analyse DESC LIMIT 2");
                         $k=1;
                         $valeur[]="";
                         foreach($examens as $examen => $examens){
                             $valeur[$k]=$examens->valeur;
                             $k++;
                         }
                         if($k>2){
                             if($elements_regle[3]=="hausse"){
                                if(((($valeur[1]-$valeur[2])/$valeur[2])*100) >= $pourcentage ) $result = 1;
                                 //if($valeur[1]>$valeur[2]) $result = 1; 
                                 else $result = 0;
                             }else {
                                if(((($valeur[1]-$valeur[2])/$valeur[2])*100) <= ($pourcentage*-1) ) $result = 1;
                                // if($valeur[1]<$valeur[2]) $result = 1; 
                                 else $result = 0;
                             }
                            // return $liste_examens[$pos_ex]."--".$valeur[1]."--".$valeur[2]."-->".$result;

                         }else $result = 0;
                         if($result==1) $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes'].$liste_examens[$pos_ex]." : ancienne valeur =".$valeur[2]." et valeur actuelle =".$valeur[1]."\n";
                         
                     }else{
                           
                            $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='".$examen_nom."' and unite ='".trim($elements_regle[$v],"()")."' and bilans.element_id = elements.id and bilans.patient_id=".$patient->id." ORDER BY bilans.date_analyse DESC LIMIT 1");
                            foreach($examens as $examen => $examens){
                                $valeur_examen = $examens->valeur;
                            }
                            //return $examen_nom."--".trim($elements_regle[$v],"()");
                            // return "val".$valeur_examen;
                            if($valeur_examen!=""){
                                $operation = $elements_regle[$v+1];
                                $examen_regle = $elements_regle[$v+2];            
                                if($operation == "="){  
                                    if($examen_regle == $valeur_examen) $result = 1;
                                    else  $result=0;
                                }else if($operation == "<="){
                                    if($valeur_examen <= $examen_regle) $result = 1;
                                    else  $result=0;
                                }else if($operation == ">="){
                                    if($valeur_examen >= $examen_regle) $result = 1;
                                    else  $result=0;
                                }else if($operation == "!="){
                                    if($valeur_examen != $examen_regle) $result = 1;
                                    else  $result=0;
                                }else if($operation == ">"){
                                    if($valeur_examen > $examen_regle) $result = 1;
                                    else  $result=0;
                                }else if($operation == "<"){
                                    if($valeur_examen < $examen_regle) $result = 1;
                                    else  $result=0;
                                }else if($operation == "+" || $operation == "-" || $operation == "/" || $operation == "*"){
                                    $valeur_examen2="";
                                    $k=$v+2; //return $elements_regle[$k];
                                    //return $regle;
                                    $examen_nom_unite="";$examen_nom2="";
                                    while(substr($elements_regle[$k], 0, 1) !="("){
                                        $examen_nom2 = $examen_nom2." ".$elements_regle[$k];  
                                        $k++;
                                        }
                                        $examen_nom_unite = $examen_nom2." ".$elements_regle[$k];
                                        // echo $examen_nom_unite;
                                            //return $examen_nom_unite;
                                        $pos_ex = array_search($examen_nom_unite,$liste_examens);
                                        if($pos_ex ==false){
                                            for($y=0 ; $y < count($liste_examens) ; $y++){
                                                $liste_examens[$y]=strtolower($liste_examens[$y]);
                                            }
                                            $pos_ex = array_search($examen_nom_unite,$liste_examens);
                                        }
                                        //return "--".$regle;
                                        //supprimer le premier espace ;
                                        $examen_nom2=ltrim($examen_nom2," ");
                                        // return "--".$examen_nom."--".trim($elements_regle[$v],"()");
                                        $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='".$examen_nom2."' and unite ='".trim($elements_regle[$k],"()")."' and bilans.element_id = elements.id and bilans.patient_id=".$patient->id." ORDER BY bilans.date_analyse DESC LIMIT 1");
                                        foreach($examens as $examen => $examens){
                                        $valeur_examen2 = $examens->valeur;
                                        }
                                        // return $valeur_examen2;
                                    if($valeur_examen != null && $valeur_examen2 != null){
                                        if($operation == "+"){  
                                            // return $valeur_examen."((".$valeur_examen2;
                                            $result_opertation = $valeur_examen + $valeur_examen2;
                                        }else if($operation == "-"){
                                            $result_opertation = $valeur_examen - $valeur_examen2;
                                        }else if($operation == "/"){
                                            $result_opertation = $valeur_examen / $valeur_examen2;
                                        }else if($operation == "*"){
                                            $result_opertation = $valeur_examen * $valeur_examen2;
                                        }
        
                                        if($elements_regle[$k+1] == "="){  
                                            if($elements_regle[$k+2] == $result_opertation) $result = 1;
                                            else  $result=0;
                                        }else if($elements_regle[$k+1] == "<="){
                                            if($result_opertation <= $elements_regle[$k+2]) $result = 1;
                                            else  $result=0;
                                        }else if($elements_regle[$k+1] == ">="){
                                            if($result_opertation >= $elements_regle[$k+2]) $result = 1;
                                            else  $result=0;
                                        }else if($elements_regle[$k+1] == "!="){
                                            if($result_opertation != $elements_regle[$k+2]) $result = 1;
                                            else  $result=0;
                                        }else if($elements_regle[$k+1] == ">"){
                                            if($result_opertation > $elements_regle[$k+2]) $result = 1;
                                            else  $result=0;
                                        }else if($elements_regle[$k+1] == "<"){
                                            if($result_opertation < $elements_regle[$k+2]) $result = 1;
                                            else  $result=0;
                                        }
                                    }else $result =0;
                                    //return $valeur_examen.$operation.$valeur_examen2."=".$result_opertation.$elements_regle[$k+1].$elements_regle[$k+2]."--->".$result;
                                }
                            }else $result =0;
                            //return $valeur_examen.$operation.$examen_regle.$result;
                            //return $regle;
        
                         }
                        // return $valeur_examen." ".$operation.$examen_regle."=".$result;
                        if($result==1){
                            if($valeur_examen2 !="") $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes'].$examen_nom." =".$valeur_examen."\n".$examen_nom2." =".$valeur_examen2."\n";
                            else $_SESSION['valeursDeclenchantes'] = $_SESSION['valeursDeclenchantes'].$examen_nom." = ".$valeur_examen."\n";
                            }
                        
                     
                
             }
             if($elements_regle[0]=="Médicament" || $elements_regle[0]=="Allergie(s)" || $elements_regle[0]=="Pathologie(s)" || $elements_regle[0]=="Produits"){
                 $x=0;
                 $chaine_a_supp="";
                 $taille_regle = count($elements_regle);
                
                 $position[]="";$p=0;
                 for($y=0 ; $y < count($liste_examens) ; $y++){
                    if($liste_examens[$y]!="Poids (kg)" && strchr($regle,$liste_examens[$y]))
                    {
                        $tab_nom_ex = explode(" ",$liste_examens[$y]);
                        for($m=0 ; $m < count($tab_nom_ex) ; $m++ ){
                            $pos = array_search($tab_nom_ex[$m],$elements_regle);
                            if($pos!=false){
                                $elements_regle[$pos] = strtolower($elements_regle[$pos]);
                                $position[$p] = $pos;$p++;
                            }
                        }
                    }
                    
                }
                for($x=0 ; $x < count($position) ; $x++ ){
                    if($position[$x]!=null){
                    $regle = str_replace(strtoupper($elements_regle[$position[$x]]),$elements_regle[$position[$x]],$regle);
                    }
                }
                 while($elements_regle[$x] != "}"){
                      $chaine_a_supp = $chaine_a_supp." ".$elements_regle[$x];
                      $x++;
                 }
                 
                 if($x != ($taille_regle-1)){
                      $chaine_a_supp =$chaine_a_supp." ".$elements_regle[$x]." ".$elements_regle[$x+1]." ";
                      
                      $regle = strstr($regle," ".$elements_regle[($x+1)]." ");
                    
                      //return $pos;
                          $regle = ltrim($regle," ".$elements_regle[($x+1)]." ");
                         // return $regle;
                          if($elements_regle[($x+1)] == "ET") $_SESSION['conditionET']  = 1;
                 }else {
                  $chaine_a_supp =$chaine_a_supp." ".$elements_regle[$x];
                  $regle = strstr($regle," ".$elements_regle[$x]." ");
                  $regle = ltrim($regle,$elements_regle[$x]);
                 }
                 if($regle == ""){ return $result;}
                 else {
                      return $result." ".$this->analyseSuivie($regle,$patient,$prescription);
                       }
             }else{

                 $chaine_a_supp="";
                 $x=0;$p=0;
                $position[]="";
                 if(in_array("ET",$elements_regle)){
                     while($elements_regle[$x] != "ET" && $x != (count($elements_regle)-1)){
                        $chaine_a_supp = $chaine_a_supp." ".$elements_regle[$x];
                        $x++;
                     }
                 }else{
                     while($elements_regle[$x] != "OU" && $x != (count($elements_regle)-1)){
                         $chaine_a_supp = $chaine_a_supp." ".$elements_regle[$x];
                         $x++;
                     }
                 }
                
                 if($elements_regle[$x] == "ET") $_SESSION['conditionET']  = 1;
                 $chaine_a_supp = $chaine_a_supp." ".$elements_regle[$x]." ";
                 for($y=0 ; $y < count($liste_examens) ; $y++){
                    if($liste_examens[$y]!="Poids (kg)" && strchr($regle,$liste_examens[$y]))
                    {
                        $tab_nom_ex = explode(" ",$liste_examens[$y]);
                        for($m=0 ; $m < count($tab_nom_ex) ; $m++ ){
                            $pos = array_search($tab_nom_ex[$m],$elements_regle);
                            if($pos!=false){
                                $elements_regle[$pos] = strtolower($elements_regle[$pos]);
                                $position[$p] = $pos;$p++;
                            }
                        }
                    }
                    
                }
                for($y=0 ; $y < count($position) ; $y++ ){
                    if($position[$y]!=null){
                    $regle = str_replace(strtoupper($elements_regle[$position[$y]]),$elements_regle[$position[$y]],$regle);
                    }
                }
                //$this->info("rr".$elements_regle[$x]);
                  if($elements_regle[$x] == "OU" ||$elements_regle[$x] == "ET"){
                    $regle = strstr($regle,$elements_regle[$x]." ");
                    $regle = ltrim($regle,$elements_regle[$x]." ");
                    
                  }else{
                    $regle = ltrim($regle,$chaine_a_supp." ");
                  }
                 // $this->info("rr".$regle);
                 if($regle == ""){ return $result;}
                 else {
                     return $result." ".$this->analyseSuivie($regle,$patient,$prescription);
                 }
             } 
     }
}
