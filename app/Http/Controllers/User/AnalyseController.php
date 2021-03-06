<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Patient;
use App\Models\Regle;
use App\Models\Reglee;
use App\Models\Education;
use App\Models\Intervention;
use App\Models\Ligneintervention;
use App\Models\Ligneprescription;
use App\Models\Prescription;
use App\Models\RegleEduPatient;
use App\Notifications\analyseNotification;
use App\Notifications\interventionNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;
use Notification;

class AnalyseController extends Controller
{
    /**
     * Avis du médecin sur l'intervention du Pharmacien sur la Prescription
     *
     * @param Request $request
     * @param integer $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return View
     */
    public function update(Request $request, $id)
    {
        $intervention = Intervention::find($id);
        $intervention->motifs_refus = $request->refus;
        $intervention->updated_by   = $request->user()->id;
        $intervention->status       = "1";
        $intervention->save();

        //Mark notification as read for all doctor users
        $users = User::all();
        foreach ($users as $user) {
            if (isset($user->role->medecin_presc) && $user->role->medecin_presc === "on") { // If is a doctor , 
                foreach ($user->unreadNotifications as $notification) {
                    if ($notification->data['prescription_id'] == $request->presc_id)
                        $user->unreadNotifications()->update(['read_at' => now()]);
                }
            }
        }

        return redirect()->back()->with(['tab' => 'tab_2']);
    }
    /**
     * Enregistre les interventions du pharmacien
     *
     * @return void
     * @author 
     **/
    public function store(Request $request)
    {

        $intervention                      = new Intervention;
        $intervention->date_ip             = date('Y-m-d H:i:s');
        $intervention->global_comment      = $request->global_comment;
        $intervention->created_by          = $request->user()->id;
        $intervention->patient_id          = $request->patient_id;
        $intervention->prescription_id     = $request->presc_id;
        $intervention->first_prob          = $request->first_prob;
        $intervention->second_prob         = $request->second_prob;
        $intervention->third_prob          = $request->third_prob;
        $intervention->status              = "0";
        $intervention->patient_decision    = $request->patient_decision;
        $intervention->pharmacien_decision = $request->pharmacien_decision;
        $intervention->save();
        for ($i = 0; $i < count($request->med_sp); $i++) {

            $ligne = new Ligneintervention;
            $ligne->intervention_id = $intervention->id;
            $ligne->ip              = $request->ip[$i];
            $ligne->comment_ip      = $request->comment_ip[$i];
            $ligne->prob_lvl      = $request->prob_lvl[$i];
            $ligne->comment_prob    = $request->comment_prob[$i];
            if (isset($request->problemes[$request->med_sp_id[$i]])) {
                $problemes = implode(',', $request->problemes[$request->med_sp_id[$i]]);
                $ligne->problemes   = $problemes;
            }
            $ligne->med_sp          = $request->med_sp[$i];
            $ligne->med_sp_id       = $request->med_sp_id[$i];
            if (isset($request->med_sp_1[$i]))
                $ligne->med_sp_1    = $request->med_sp_1[$i];
            $ligne->save();
        }
        $presc = Prescription::find($request->presc_id);
        $presc->etats = 'invalide';
        $presc->save();

        // broadcast(new \App\Events\PrescriptionAnalyse("medecin_presc", $request->presc_id, $request->user()))->toOthers();

        //Mark notification as read for all pharmacists user
        $users = User::all();
        foreach ($users as $user) {
            if (isset($user->role->analyse_ph) && $user->role->analyse_ph === "on") { // If is a pharmacist , 
                foreach ($user->unreadNotifications as $notification) {
                    if ($notification->data['prescription_id'] == $request->presc_id)
                        $user->unreadNotifications()->update(['read_at' => now()]);
                }
            }
        }

        //Notify Doctors that Intervention of pharamcist has done, and its waiting for you accept
        foreach ($users as $user) {
            if (isset($user->role->medecin_presc) && $user->role->medecin_presc === "on")  // If is a pharmacist , 
                Notification::send($user, new interventionNotification($intervention)); //send notification 
        }

        return redirect(route('intervention.show'))->with('message', 'Intervention envoyé au médecin avec succées !');
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function edit($interv_id)
    {
        $ip = Intervention::find($interv_id);
        $lignes_ip = $ip->lignesIP;
        return response()->json([
            "ip"     => $ip,
            "lignes" => $lignes_ip
        ]);
    }

    public function details_education($patient_id, $pres_id)
    {
        /*$pres = Prescription::find($pres_id);
        $pres->etatAnalyseTherap ="risqueTherap";
            $pres->save();*/
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
        $regles_edu = DB::select("select * from education,regle_edu_patients where patient_id =" . $patient_id . " and regle_edu_patients.regle_id=education.id and regle_edu_patients.prescription_id=" . $pres_id);
        //return response()->json(["si" =>$si]);
        foreach ($regles_edu as $reg => $regles_edu) {

            $si = $regles_edu->si;
            $titre = $regles_edu->titre;
            $commentaire = $regles_edu->commentaire;
            $maladie = $regles_edu->maladie;
            $effet = $regles_edu->effet;
            $voyage = $regles_edu->voyage;
            $act = $regles_edu->act;
            $utilisation = $regles_edu->utilisation;
            $effet_indiserable = $regles_edu->effet_indiserable;
            $regime = $regles_edu->regime;
            $url = $regles_edu->url;
            $pdf = $regles_edu->pdf;
        }

        return response()->json(['si' => $si, 'titre' => $titre, 'commentaire' => $commentaire, 'maladie' => $maladie, 'effet' => $effet, 'voyage' => $voyage, 'act' => $act, 'utilisation' => $utilisation, 'effet_indiserable' => $effet_indiserable, 'regime' => $regime, 'url' => $url, 'pdf' => $pdf]);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author SalafiWhiteProgrammer
     **/
    public function pre_analyse_interne($patient_id, $pres_id)
    {

        // recuperer le profile patient
        $patient = Patient::find($patient_id);

        //recuperer les regles internes
        $reglees = Reglee::all();

        // recuperer la prescription
        $prescription  = Prescription::find($pres_id);

        //session_start();

        $_SESSION['conditionET'] = 0;
        $c = 0;
        $o = 0;
        $condition = 0;
        $resultatAnalyse[] = "";
        $alert2[] = "";
        $alors[] = "";
        $commentraire[] = "";
        $si[] = "";
        $id_regles_active[] = "";

        foreach ($reglees as $reglee) {
            $_SESSION['conditionET'] = 0;
            $alert2 = $this->analyseInterne($reglee->si, $patient, $prescription);
            if ($_SESSION['conditionET'] == 1) {
                if (strchr($alert2, "0") != null) $resultatAnalyse[$c] = 0;
                else {
                    $resultatAnalyse[$c] = 1;
                }
            } else {
                if (strchr($alert2, "1")) {
                    $resultatAnalyse[$c] = 1;
                } else $resultatAnalyse[$c] = 0;
            }
            if ($resultatAnalyse[$c] == 1) {
                $prescription->etatAnalyseInterne = "risqueInterne";
                $prescription->save();
                $si[$o] = $reglee->si;
                $alors[$o] = $reglee->alors;
                $commentraire[$o] = $reglee->commentaire;
                $id_regles_active[$o] = $reglee->id;
                $o++;
            }
            $c++;
        }
        return response()->json(['array_id' => $id_regles_active, 'si' => $si, 'alors' => $alors, 'commentaire' => $commentraire]);
    }
    /**
     * notify all users
     *
     * @return void
     * @author 
     **/
    private function notifyUsers(Prescription $prescription)
    {
        $users = User::all(); // Notify user pharmacists
        foreach ($users as $user) {
            if (isset($user->role->analyse_ph) && $user->role->analyse_ph === "on")  // If is a pharmacist , 
                Notification::send($user, new analyseNotification($prescription)); //send notification ( i.e : store to DB)
        }
    }
    /**
     * Lancement de la procédure de Pre-Analyse
     * bouton envoyer au pharmacien
     * @return void
     * @author SalafiWhiteProgrammer
     **/
    public function pre_analyser($patient_id, $pres_id)
    {
        // 1- recuperer le profile patient ( age , pathologie , allergie , poids )
        // 2- recuperer les lignes prescription
        // 3- recuperer les regles activé
        // 4 - lancer la préanalyse

        // recuperer le profile patient
        $patient = Patient::find($patient_id);

        //recuperer les regles internes
        $reglees = Reglee::all();

        //recuperer les regles de l'éducation thérapeutique
        $regleesEdu = Education::all();

        // recuperer la prescription
        $prescription  = Prescription::find($pres_id);
        session_start();
        $_SESSION['conditionET'] = 0;
        $c = 0;
        $o = 0;
        $condition = 0;
        $resultatAnalyse[] = "";
        $alert2[] = "";
        $alors[] = "";
        $commentraire[] = "";
        $si[] = "";

        if ($this->isAnalyseAuto() == 'off') // si analyse auto desactive envoyer tout les prescriptions au farmacien
        {
            $prescription->etats = "risque";
            $prescription->save();

            return redirect()->back()->with('message', 'La Prescription est envoyée aux Pharmacien pour analyse.');
        } else {
            foreach ($regleesEdu as $reglee) {
                $_SESSION['conditionET'] = 0;

                $alert2 = self::analyseTherapeutique($reglee->si, $patient, $prescription, null);
                if ($_SESSION['conditionET'] == 1) {
                    if (strchr($alert2, "0") != null) {
                        $resultatAnalyse[$c] = 0;
                        //return $resultatAnalyse[0];
                    } else {
                        $resultatAnalyse[$c] = 1;
                    }
                    //return "--".strchr($alert2,"0")."--";
                } else {
                    if (strchr($alert2, "1")) {
                        $resultatAnalyse[$c] = 1;
                    } else $resultatAnalyse[$c] = 0;
                }
                //if($c==3)return $alert2."--".$reglee->id."------->".$resultatAnalyse[$c]."car".$_SESSION['conditionET'];

                if ($resultatAnalyse[$c] == 1) {
                    $regl = RegleEduPatient::where(['patient_id' => $patient->id, 'regle_id' => $reglee->id, 'prescription_id' => $prescription->id])->first();
                    if ($regl != null) {
                    } else {
                        $prescription->etatAnalyseTherap = "risqueTherap";
                        $prescription->save();
                        $edu_regle_pres = new RegleEduPatient();
                        $edu_regle_pres->patient_id = $patient->id;
                        $edu_regle_pres->regle_id = $reglee->id;
                        $edu_regle_pres->prescription_id = $prescription->id;
                        $edu_regle_pres->save();
                    }
                }
                $c++;
            }
            $c = 0;
            $alert2 = "";
            $resultatAnalyse[] = "";

            foreach ($reglees as $reglee) {
                $_SESSION['conditionET'] = 0;
                $alert2 = $this->analyseInterne($reglee->si, $patient, $prescription);
                if ($_SESSION['conditionET'] == 1) {
                    if (strchr($alert2, "0") != null) $resultatAnalyse[$c] = 0;
                    else {
                        $resultatAnalyse[$c] = 1;
                    }
                } else {
                    if (strchr($alert2, "1")) {
                        $resultatAnalyse[$c] = 1;
                    } else $resultatAnalyse[$c] = 0;
                }
                //if($c==5) return $alert2;

                if ($resultatAnalyse[$c] == 1) {
                    $prescription->etatAnalyseInterne = "risqueInterne";
                    $prescription->etats = "risque";
                    $prescription->date_etats_risque = now();
                    $prescription->save();
                    $this->notifyUsers($prescription);
                    return redirect()->back()->with('message', 'La Prescription représente un risque! le Pharmacien sera notifier pour analyse.');
                }
                $c++;
            }
        }
        $prescription->etats = "rétro";
        $prescription->save();
        return redirect()->back()->with('message', 'La Prescription ne représente aucun risque!');
    }

    /**
     * Check if analyse auto is activate or not
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return boolean
     */
    private function isAnalyseAuto()
    {
        // si la prescription reprsent no risks
        $string = file_get_contents(public_path() . "/js/json/general_settings.json"); //recuperer la valeru de l'analyse auto
        $json_a = json_decode($string, true);
        $status_analyse_auto = $json_a['analyse_auto']; // 'off' or 'on'
        return $status_analyse_auto;
    }
    /**
     * Pre-analyse  de la Prescription
     *
     * @return $boolean
     * @author 
     **/
    protected function analyser($regle, $patient, $prescription)
    {
        // 1-tester sur chaque regle activé
        // 2-retourner un message d'erreur si contrainte de regle non respecté
        // 2.1- sinon passer à la regle suivante
        $poids = "";
        if ($regle->type_regle === "Surdosage") {
            Log::info('Analyse sur la règle : Surdosage');

            Log::info('Resortir le type age du patient');
            $type = $this->type_age($patient->date_naissance); //récuperer le type d'age du patient
            Log::info('Type ressortis : ' . $type);

            $poids = $patient->poids;

            $path_pat = $patient->pathologies;

            $age = floatval(date('Y/m/d', strtotime("now"))) - floatval(date('Y/m/d', strtotime($patient->date_naissance)));
            Log::info('Analysr surdosage pour chaque médicaments de la prescription.');
            foreach ($prescription->lignes as $ligne) // On TEST le SURDOSAGE pour chaque MEDICAMENTS PRESCRITS
            {
                $clairance = null;
                Log::info('Test element biologique avec le médicament correspondant');
                //on resort la créatinine tu patien en umol/l
                foreach ($patient->bilansMax as $bilan) // on resort les dernier bilans du patient
                    if ($bilan->element && ($bilan->element->element ===  "K+" || $bilan->element->element ===  "k+")) { // Si le bilan 'créatinine' existe 
                        $creat = ($bilan->element->unite == 'mg/dL') ? ($bilan->valeur * 88.4) : $bilan->valeur; // recupérer la valeur de créat
                        Log::info('Calcule de la clairance ....');
                        $sexe = $patient->sexe;
                        $clairance = $this->calcul_clr($patient->taille, $sexe, $poids, $age, $creat, $patient->grossesse_id);
                        Log::info('Clairance :' . $clairance);
                    }


                Log::info('Lancement de la fonction Surdosage() ....');
                $surdosage = $this->surdosage($ligne, $type, $age, $poids, $path_pat, $clairance, null);
                Log::info('("************FIN de léxécution surdosage()"************');

                if (!$surdosage) { // if false or null
                    Log::info('Insérer dans la table pre-analyse lalert.');
                    DB::table('pre_analyses')->insert([
                        'patient_id' => $patient->id,
                        'regle_id'   => $regle->id,
                        'created_at' => $prescription->created_at
                    ]);
                    Log::info('Présence de Surdosage');
                    return false;
                }
            } //END FOREACH MEDICAMENTS
            Log::info('Pas de surdosage.');
            Log::info('("************FIN analyse sur la règle : Surdosage("************');
        } //END IF SURDOSAGE

        if ($regle->type_regle === "CI") {
            Log::info('Analyse sur la règle : Contre indication');
            //1 - oN RETOURNE toute les CONTRE INDICATIONS  du MEDICAMENT
            // 2 - pour chaque contre indication on test par rapport à l'age , aux allergies , et aux pathlogies du patient
            // 3 - Si l'un des terrains du patient est présent dans les CONTRE INDICATIONS on retourne une alerte
            $pat_allergie = $patient->allergies; // les allergies du patient
            $path_pat = $patient->pathologies; // les pathlogies du patient
            $type = $this->type_age($patient->date_naissance); // LE TYPE d'age DU PATEINT
            foreach ($prescription->lignes as $ligne) //gerer les ci absolue pour chaque medicament
            {
                // Retourner toute les contre indications absolue de la spécialité en question
                $cis_absolue = DB::select(" select  t3.cdf_nom , t5.NIVCOM_FCPM_CODE_FK_PK as code_fiche 
                                            FROM   fcpmsp_cipemg_spe T1, cdf_codif t3 ,nivcom_niveau_commentaire t5
                                            WHERE t5.NIVCOM_FCPM_CODE_FK_PK = T1.FCPMSP_FCPM_CODE_FK_PK 
                                            and t3.cdf_code_pk=t5.nivcom_cdf_ter_code_fk_pk
                                            and t5.NIVCOM_CDF_COM_CODE_FK_PK ='X9'
                                            AND T1.FCPMSP_SP_CODE_FK_PK       = ?
                                            ORDER BY 1 ", [$ligne->med_sp_id]); // x9 code cdf_codif = contreindication absolue

                for ($i = 0; $i < count($cis_absolue); $i++) { //pour chaque contre indciation absolue
                    if ($cis_absolue[$i]->cdf_nom === $type) { // test par rapport à l'age
                        DB::table('pre_analyses')->insert([
                            'patient_id' => $patient->id,
                            'regle_id'   => $regle->id,
                            'created_at' => $prescription->created_at
                        ]);
                        return false;
                    }

                    if ($pat_allergie != null) {
                        if ($cis_absolue[$i]->cdf_nom === "HYPERSENSIBILITE") { // test par rapprot à l'allergie
                            // resortir les allergies du médicament   

                            $allergies = $this->allergies($ligne->med_sp_id, $cis_absolue[$i]->code_fiche);
                            foreach ($pat_allergie as $p_allergie) //pour chaque allergie du patient     
                                foreach ($allergies as $allergie)
                                    if ($p_allergie->id === $allergie->code_comment_terrain) {
                                        DB::table('pre_analyses')->insert([
                                            'patient_id' => $patient->id,
                                            'regle_id'   => $regle->id,
                                            'created_at' => $prescription->created_at
                                        ]);
                                        return false;
                                    }
                        }
                    } //end  if allergie not empty


                    // END IF HYPERSENSIBILITE       
                    if ($path_pat != null) //si le patient à des pathologies
                        foreach ($path_pat as $path)  // test par rapport à la pathologie
                            if ($cis_absolue[$i]->cdf_nom  === $path->pathologie) {
                                DB::table('pre_analyses')->insert([
                                    'patient_id' => $patient->id,
                                    'regle_id'   => $regle->id,
                                    'created_at' => $prescription->created_at
                                ]);
                                return false;
                            }
                } // END LOOP CONTRE INDICATION ABSOLUE
            } // END LOOP lignes prescription
        } // END IF TYPE_REGLE => CI

        if ($regle->type_regle === "mmte") { // a revoir pour le dci a plusieur codes

            //tester chaque medicament dci si il est de type mmte
            foreach ($prescription->lignes as $ligne) {
                Log::info('Analyse sur la règle : mmte');
                //resortir le(s) médicament(s) DCI du médicament spécialité de la ligne prescription
                $result_dci = DB::table('cosac_compo_subact')
                    ->select('cosac_sac_code_fk_pk')
                    ->where('cosac_sp_code_fk_pk', $ligne->med_sp_id)
                    ->get();

                //pour chaque dcis resortis , on test si il est égal au(x) mmte dci(s) de la règle
                foreach ($result_dci as $dci)
                    if ($dci->cosac_sac_code_fk_pk === $regle->mmte_id) {
                        DB::table('pre_analyses')->insert([
                            'patient_id' => $patient->id,
                            'regle_id'   => $regle->id,
                            'created_at' => $prescription->created_at
                        ]);
                        return false;
                    }

                // resortir toutes les classe pour le dci
                $classe_dci = DB::table('saccph_subact_classeph')
                    ->select('saccph_cph_code_fk_pk')
                    ->where('saccph_sac_code_fk_pk', $dci->cosac_sac_code_fk_pk)
                    ->get();

                // ON TEST LE CODE CLASSE DE LA REGLE AVEC LES CLASSES RESORTIS
                foreach ($classe_dci as $classe) {
                    if ($regle->classe_id === $classe->saccph_cph_code_fk_pk) {
                        DB::table('pre_analyses')->insert([
                            'patient_id' => $patient->id,
                            'regle_id'   => $regle->id,
                            'created_at' => $prescription->created_at
                        ]);
                        return false;
                    }
                }
            }
        }

        if ($regle->type_regle === "patient") { //tester pour la regle des elements d'examens
            Log::info('Analyse sur la règle : patient');
            foreach ($prescription->lignes as $ligne) { // tester pour chaque ligne prescription
                Log::info('Resortir médicament(s) DCI. num :' . $ligne->med_sp_id);
                //resortir le(s) médicament(s) DCI du médicament spécialité de la ligne prescription
                $result_dci = DB::table('cosac_compo_subact')
                    ->select('cosac_sac_code_fk_pk')
                    ->where('cosac_sp_code_fk_pk', $ligne->med_sp_id)
                    ->get();
                Log::info('Verification Médicaments DCI (id) avec Médicament DCI (id) de la règle...');
                //pour chaque dcis resortis , on test si il est égal au(x) dci(s) de la règle
                foreach ($result_dci as $dci) {
                    Log::info('Médicament DCI num :' . $dci->cosac_sac_code_fk_pk);
                    foreach ($regle->medicament as $r_dci) {
                        Log::info('Médicament DCI  Règle num :' . $r_dci->SAC_CODE_SQ_PK);
                        Log::info("Vérification égalite médicaments...");
                        if ($dci->cosac_sac_code_fk_pk === $r_dci->SAC_CODE_SQ_PK) {
                            Log::info('Corresponds!');

                            Log::info('Verfication le bilan du patient avec élément biologique de la règle');
                            $bilan_result = $this->test_bilans($patient, $regle); //SI IL Y EGALITE ON VERIFIE LES ELEMENTS EXAMENS
                            Log::info('FIN verfication!');

                            if (!$bilan_result) {
                                Log::info('FIN Verification Médicaments DCI (id) avec Médicament DCI (id) de la règle...');
                                Log::warning('Bilan patient sup à element de la règle');
                                Log::info('Insertion alertes dans table (pré-analyse)');
                                DB::table('pre_analyses')->insert([
                                    'patient_id' => $patient->id,
                                    'regle_id'   => $regle->id,
                                    'created_at' => $prescription->created_at
                                ]);
                                return false;
                            }
                        } //end fif
                    }
                    // 2 eme test : on verfie avec la classe de la regle
                    // on ressort la(les) classe du dci en question
                    $classe_dci = DB::table('saccph_subact_classeph')
                        ->select('saccph_cph_code_fk_pk')
                        ->where('saccph_sac_code_fk_pk', $dci->cosac_sac_code_fk_pk)
                        ->get();
                    Log::info('Verification Médicaments classe (id) du patient avec Médicament classe (id) de la règle...');
                    // ON TEST LE CODE CLASSE DE LA REGLE AVEC LES CLASSES RESORTIS
                    foreach ($classe_dci as $classe) {
                        Log::info('Médicament classe patient num :' . $classe->saccph_cph_code_fk_pk);
                        Log::info('Médicament classe règle num :' . $regle->classe_id);
                        if ($regle->classe_id === $classe->saccph_cph_code_fk_pk) {
                            Log::info('Corresponds!');

                            Log::info('Verfication le bilan du patient avec élément biologique de la règle');
                            $bilan = $this->test_bilans($patient, $regle);
                            Log::info('FIN verfication!');

                            if (!$bilan) {
                                Log::warning('Bilan patient sup à element de la règle');
                                Log::info('Insertion alertes dans table (pré-analyse)');
                                DB::table('pre_analyses')->insert([
                                    'patient_id' => $patient->id,
                                    'regle_id'   => $regle->id,
                                    'created_at' => $prescription->created_at
                                ]);
                                return false;
                            }
                        }
                    }
                }
            }
            Log::info('Règle patient clean.');
            Log::info('("************FIN analyse sur la règle : Patient("************');
        }

        if ($regle->type_regle === "Phytotherapie") { // tester pour la regle : Phytotherapie
            Log::info('Analyse sur la règle : Phytotherapie');
            # METHODE :
            # 1- Resortir , pour chaque lignes de la prescription les codes DCI
            # 2- Resortir les produit alimentaire du patient
            # 3- Pour chaque produit alimentaire qu'il prends , resortir les médicaments (code) DCI qui interagisent avec ce produit
            # 4- Tester Si il y a la présence de médicament (code) DCI dans la prescription
            $phyto_patient = $patient->phytos;
            foreach ($prescription->lignes as $ligne) {
                $result_phyto = $this->interaction_alimentaire($ligne->med_sp_id, $phyto_patient, null);
                if (!$result_phyto) {
                    DB::table('pre_analyses')->insert([
                        'patient_id' => $patient->id,
                        'regle_id'   => $regle->id,
                        'created_at' => $prescription->created_at
                    ]);
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * Fonction traite l'analyse pharmaceutique
     * 
     * @return alertes[]
     * @author SidouSalafiWhiteProgrammer
     **/
    protected function analyse_ph($patient_id, $pre_risque_id)
    {
        /*
        *   1 - Resortir tout les lignes prescriptions : prescription a risque , automédication et traitement en cours.
        *   2 -  
        */
        $redondances_tmp = $interactions_tmp = $pe_tm = $ci_tmp = $ad_tmp = $surdosage_tmp = $interactions_alim_tmp = "";
        $rd = [];

        $poids = "";

        $count = DB::table('statistiques')->where('prescription_id', $pre_risque_id)->count();
        if ($count > 0)
            DB::table('statistiques')->where('prescription_id', $pre_risque_id)->delete();

        $meds_sp_presc = DB::table('ligneprescriptions')
            ->join('prescriptions', 'prescriptions.id', 'ligneprescriptions.prescription_id')
            ->join('sp_specialite', 'sp_specialite.SP_CODE_SQ_PK', 'ligneprescriptions.med_sp_id')
            ->whereNull('ligneprescriptions.tmp')
            ->where('prescriptions.patient_id', $patient_id)
            ->where('prescriptions.id', $pre_risque_id)
            ->select('ligneprescriptions.*', 'sp_specialite.*')
            ->get();

        $meds_sp_trait = DB::table('traitementchroniques')
            ->join('ligneprescriptions', 'traitementchroniques.id', 'ligneprescriptions.traitementchronique_id')
            ->join('sp_specialite', 'sp_specialite.SP_CODE_SQ_PK', 'ligneprescriptions.med_sp_id')
            ->where('traitementchroniques.patient_id', $patient_id)
            ->whereNull('ligneprescriptions.tmp')
            ->where('ligneprescriptions.etats', 'En cours')
            ->select('ligneprescriptions.*', 'sp_specialite.*')
            ->get();
        $meds_sp_auto  = DB::table('automedications')
            ->join('ligneprescriptions', 'automedications.id', 'ligneprescriptions.automedication_id')
            ->join('sp_specialite', 'sp_specialite.SP_CODE_SQ_PK', 'ligneprescriptions.med_sp_id')
            ->where('automedications.patient_id', $patient_id)
            ->whereNull('ligneprescriptions.tmp')
            ->where('ligneprescriptions.etats', 'En cours')
            ->select('ligneprescriptions.*', 'sp_specialite.*')
            ->get();
        $result        = $meds_sp_trait->merge($meds_sp_presc);
        $lignes        = $result->merge($meds_sp_auto);
        $patient       = Patient::find($patient_id);
        $type          = $this->type_age($patient->date_naissance); // LE TYPE d'age DU PATEINT               
        $poids = $patient->poids;
        $age = floatval(date('Y/m/d', strtotime("now"))) - floatval(date('Y/m/d', strtotime($patient->date_naissance)));

        Log::info("/**/*/**/*/*/*/*/*/**Lancement de l'analyse de la prescription/**/*/**/*/*/*/*/*/**");
        $j = 1;
        foreach ($lignes as $key => $ligne) // TEST REDODNANCE ET INTERACTION MEDICAMENTEUSE
        {
            $redondances_tmp = $interactions_tmp = array(); //INITIALIZE 
            $dci  = $this->getDCIS($lignes[$key]->med_sp_id); // get composite DCI from SP code
            Log::info('Médicament DCI :' . $dci);

            for ($i = $j, $lines = count($lignes); $i < $lines; $i++) // TEST EIM WITH OTHER MEDIC OF PRESCRIPTION
            {
                Log::info("Médicament SP n01 :" . $ligne->med_sp_id);
                Log::info("Médicament SP n02 :" . $lignes[$i]->med_sp_id);

                Log::info("Verification redondance......");
                $redondancess_tmp     = $this->redondance($ligne, $lignes[$i]);
                Log::info("************FIN Verification redondance************");


                Log::info("Verification Interaction médicamenteuse DCI.......");
                $interactionss_tmp    = $this->interaction_medicamenteuse($lignes[$key]->med_sp_id, $lignes[$i]->med_sp_id);
                Log::info("************FIN Verification Interaction médicamenteuse DCI************");

                Log::info("Verification Interaction médicamenteuse SP.............");
                $interactionss_sp_tmp = $this->interaction_sp_medicamenteuse($lignes[$key]->med_sp_id, $lignes[$i]->med_sp_id);
                Log::info("************FIN Verification Interaction médicamenteuse SP************");

                if ($redondancess_tmp     != null) {
                    $this->storeToStats('Intéraction médicamenteuse', $pre_risque_id);
                    $redondances_tmp[] = $redondancess_tmp;
                }
                if ($interactionss_tmp    != null) {
                    $this->storeToStats('Intéraction médicamenteuse', $pre_risque_id);
                    $interactions_tmp[] = $interactionss_tmp;
                }
                if ($interactionss_sp_tmp != null) {
                    $this->storeToStats('Intéraction médicamenteuse', $pre_risque_id);
                    $interactions_tmp[] = $interactionss_sp_tmp;
                }
            } //* End for
            $j = $j + 1;
            //$i = $j;

            $interactions_alim_tmp   = $this->test_interaction_alimentaire($lignes[$key]->med_sp_id, $patient->phytos);
            $pe_tmp                  = $this->get_pe($lignes[$key]->med_sp_id, $patient->allergies, $patient->pathologies, $patient->etat);
            $ci_tmp                  = $this->get_ci($lignes[$key]->med_sp_id, $patient->allergies, $patient->pathologies, $patient->etat);
            $ad_tmp                  = $this->get_ad($lignes[$key]->med_sp_id, $patient->allergies, $patient->pathologies, $patient->etat);
            $surdosage_tmp           = $this->test_surdosage($ligne, $patient->sexe, $patient->bilansMax, $age, $poids, $patient->pathologies, $type, $patient->grossesse_id, $patient->taille);

            // store into 'statistiques' table
            if (!empty($redondances_tmp))        $this->storeToStats('Intéraction médicamenteuse', $pre_risque_id);
            if ($interactions_alim_tmp != NULL && $interactions_alim_tmp[0] != "")   $this->storeToStats('Intéraction alimentaire', $pre_risque_id);
            if (!empty($pe_tmp))                 $this->storeToStats('Précaution d emploi', $pre_risque_id);
            if (!empty($ci_tmp))                 $this->storeToStats('Contre indication', $pre_risque_id);
            if (!empty($ad_tmp))                 $this->storeToStats('Association déconseillé', $pre_risque_id);
            if (!empty($surdosage_tmp))          $this->storeToStats('Surdosage', $pre_risque_id);


            $redondances             = array("redondance"              => $redondances_tmp);
            $interactions            = array("interaction"             => $interactions_tmp);
            $interactions_alim       = array("interaction_alimentaire" => $interactions_alim_tmp);
            $pe                      = array("Precaution_emploi"       => $pe_tmp);
            $ci                      = array("contre_indication"       => $ci_tmp);
            $ad                      = array("Association_deconseillé" => $ad_tmp);
            $surdosage               = array("Surdosage"               => $surdosage_tmp);
            $tmp                     = array_merge($pe, $ci, $surdosage, $interactions, $redondances, $interactions_alim);


            $rd[]                    = array("dci" => $dci, "medicament" => $lignes[$key]->med_sp_id, "alertes" => $tmp);
        } // FIN FOREACH LIGNES 
        return response()->json([$rd, "presc_id" => $pre_risque_id]);
    }

    /**
     * Save to Statistique Table
     *
     * @return void
     * @author 
     **/
    protected function storeToStats($type, $pre_risque_id)
    {
        DB::table('statistiques')->insert([
            'type_effet'      => $type,
            'date_analyse'    => date('Y-m-d'),
            'prescription_id' => $pre_risque_id
        ]);
        return;
    }

    /**
     * Analyse Surodosage Medicament selon Profil Patient
     *
     * @param [type] $ligne
     * @param [type] $sexe
     * @param [type] $pat
     * @param [type] $age
     * @param [type] $poids
     * @param [type] $pathologies
     * @param [type] $type
     * @param [type] $grossesse_id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function test_surdosage($ligne, $sexe, $pat, $age, $poids, $pathologies, $type, $grossesse_id, $taille)
    {
        $clairance = 100;
        foreach ($pat as $bilan) // on resort les dernier bilans du patient
            if ($bilan->element && ($bilan->element->element ===  "K+" || $bilan->element->element ===  "k+")) { // Si le bilan 'créatinine' existe 
                $creat = ($bilan->element->unite == 'mg/dl') ? ($bilan->valeur * 88.4) : $bilan->valeur; // recupérer la valeur de créat
                $clairance = $this->calcul_clr($taille, $sexe, $poids, $age, $creat, $grossesse_id);
                Log::info('Clairance :' . $clairance);
            }

        $surdosage = $this->surdosage($ligne, $type, $age, $poids, $pathologies, $clairance, '1');
        if (is_array($surdosage)) {
            Log::info('Détection de Surdosage.');
            return $surdosage;
        }
        Log::info('Pas de surdosage.');
        return [];
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function surdosage($ligne, $type, $age, $poids, $pathologies, $clairance, $flag)
    {
        $dose_journ = $ligne->dose_mat + $ligne->dose_mid + $ligne->dose_soi + $ligne->dose_ac;
        Log::info('Dose journalière :' . $dose_journ);
        $schéma_id = "";
        // 1 - On ressort tout les shcemas posologique de la spécialité
        // 2 - On verfie si le terrain du schéma en question répond bien au profil patient
        // 3 - le schéma posologique trouvé on récupere l'identifiant de la posologie 
        // 4 - grace à l'identifiant de la posologie on recherche dans la table ipo_info_poso : frequence max journalière (ipo_freqmax)
        // 5 - la fréquence max récuperer , on compare avec la dose journalière prescrit
        // 5.1 - si dépasse alors retourner une alerte et on passe au med suivant , sinon on passe au médicament suivant
        Log::info('ressortir tout les schémas posologique de la spécialité.');
        // 1 - On ressort tout les shcemas posologique de la spécialité
        $schemas_poso =  DB::select("select fposp_fpo_code_fk_pk 
                from fposp_poso_spe
                where fposp_sp_code_fk_pk = ?", [$ligne->med_sp_id]);
        Log::info('verfier si le terrain du schéma en question répond bien au profil patient...');
        // 2 - On verfie si le terrain du schéma en question répond bien au profil patient
        for ($i = 0; $i < count($schemas_poso); $i++) {
            // retourner les  terrain du schéma POSOLOGIQUE de la spécialité en question   
            Log::info('Schéma posologique num :' . $schemas_poso[$i]->fposp_fpo_code_fk_pk);

            Log::info('retourner les  terrain du schéma POSOLOGIQUE de la spécialité en .');
            $groupes  = DB::select("select count(fpote_grp_code_pk) 
                    FROM fpote_fposo_terrain  
                    where
                     FPOTE_FPO_CODE_FK_PK= ? 
                     group by fpote_grp_code_pk", [$schemas_poso[$i]->fposp_fpo_code_fk_pk]);
            Log::info('Nombre de terrains : ' . count($groupes));

            Log::info('parcours des groupes de terrains...');
            for ($j = 0; $j < count($groupes); $j++) { // on parcours tout les groupes

                $terrain  = DB::select("select * , cdf_nom 
                        FROM fpote_fposo_terrain as t0 , cdf_codif as t1 
                        where
                        t0.FPOTE_CDF_TEPO_CODE_FK_PK = t1.CDF_CODE_PK
                        and
                         FPOTE_FPO_CODE_FK_PK= ?
                        and
                         t1.CDF_NUMERO_PK = 'PT' and fpote_grp_code_pk = ? order by fpote_numord
                         ", [$schemas_poso[$i]->fposp_fpo_code_fk_pk, $j + 1]);

                $compt = 0;
                Log::info('Verification corespondance du terrain au patient...');
                for ($k = 0; $k < count($terrain); $k++) { // on parcours tout les élements du terrain du groupe
                    Log::info('Verification Type dage...');
                    if ($terrain[$k]->cdf_nom == $type) { // verifie type d'age
                        $compt++;
                        Log::info('correspond!');
                    }
                    Log::info('FIN Verification Type dage.');

                    Log::info('Verification Mesure age/poids...');
                    if ($terrain[$k]->min != null &&  $terrain[$k]->max != null) { // on verifie au rapport mesure 
                        Log::info('Min et max != null :');
                        Log::info('Lancement de la fonction compareMesure()...');
                        $p_mesure = $this->compareMesure($terrain[$k]->unit, $age, $poids); // return wich mesure of patient :age, jour, moi, poids . correspond to unit of terrain

                        if ($terrain[$k]->min <= $p_mesure && $p_mesure <= $terrain[$k]->max) { // on vérifie entre min et max
                            $compt++;
                            Log::info('correspond!');
                        }
                    }

                    if ($terrain[$k]->min != null && $terrain[$k]->max == null) {
                        Log::info(' max = null , comparé avec le min :');
                        Log::info('Lancement de la fonction compareMesure()...');
                        $p_mesure = $this->compareMesure($terrain[$k]->unit, $age, $poids); // return wich mesure of patient :age, jour, moi, poids . correspond to unit of terrain

                        if ($terrain[$k]->min <= $p_mesure) { // on compare avec le min
                            $compt++;
                            Log::info('correspond!');
                        }
                    }

                    if ($terrain[$k]->min == null && $terrain[$k]->max != null) {
                        Log::info(' Min = null ,comparé avec le max :');
                        Log::info('Lancement de la fonction compareMesure()...');
                        $p_mesure = $this->compareMesure($terrain[$k]->unit, $age, $poids); // return wich mesure of patient :age, jour, moi, poids . correspond to unit of terrain

                        if ($p_mesure <= $terrain[$k]->max) { // on compare avec le max
                            Log::info('correspond!');
                            $compt++;
                        }
                    }
                    Log::info('FIN Verification Mesure age/poids.');

                    Log::info('Verification pathologies du patient...');
                    foreach ($pathologies as $path) {
                        // if ($terrain[$k]->CDF_CODE_PK == 'P13' && ( $path->id == 'U2' || $path->id == 'NA')) {// insuffisance rénale OU léger , D14 : léger
                        //     $compt++;
                        // }
                        // if ($terrain[$k]->CDF_CODE_PK == 'D14' && ( $path->id == 'U2' || $path->id == 'NA')) {// insuffisance rénale OU léger , D14 : léger
                        //     $compt++;
                        // }
                        Log::info('Pathologie patient : ' . $path->id);
                        Log::info('Pathologie terrain : ' . $terrain[$k]->CDF_CODE_PK);
                        Log::info('Clairance patient  : ' . $clairance);
                        if ($terrain[$k]->CDF_CODE_PK == 'D14'  && $clairance != null && ($clairance > 60 && $clairance <= 90)) { // insuffisance leger severe et clairance <=30
                            $compt++;
                        }

                        if ($terrain[$k]->CDF_CODE_PK == 'D7'  && $clairance != null && ($clairance > 30 && $clairance <= 60)) { // insuffisance rénale modérer et clairance entre 30 et 60
                            $compt++;
                        }
                        if ($terrain[$k]->CDF_CODE_PK == 'D8'  && $clairance != null && $clairance <= 30) { // insuffisance rénale severe et clairance <=30
                            $compt++;
                        }
                        // if ($terrain[$k]->CDF_CODE_PK == 'D7'  && $path->id == 'NA1' ) {// insuffisance rénale moderer ? NA1 : CHRONIQUE
                        //     $compt++;
                        // }                         
                        // if ($terrain[$k]->CDF_CODE_PK == 'D8'  && $path->id == 'NA2' ) {// insuffisance rénale severe ? NA2 : AIGUE
                        //     $compt++;
                        // }
                        if ($terrain[$k]->CDF_CODE_PK == 'P12'  &&  $path->id == 'U1') { // insuffisance Hépatique 
                            $compt++;
                        }
                        if ($terrain[$k]->CDF_CODE_PK == 'P12'  &&  $path->id == 'UA1') { // insuffisance Hépatique  léger
                            $compt++;
                        }
                        if ($terrain[$k]->CDF_CODE_PK == 'P12'  &&  $path->id == 'UA2') { // insuffisance Hépatique moderer
                            $compt++;
                        }
                        if ($terrain[$k]->CDF_CODE_PK == 'P12'  && $path->id == 'UA3') { // insuffisance Hépatique grave
                            $compt++;
                        }
                    }
                    Log::info('FIN Verification pathologies du patient.');
                } //END LOOP TERRAINS
                Log::info('FIN Verification corespondance du terrain au patient.');

                if ($compt == count($terrain)) {
                    // 3 - le schéma posologique trouvé on récupere l'identifiant de la posologie 
                    Log::info('Schéma posologique ressortis !.');
                    $schéma_id = $terrain[0]->FPOTE_FPO_CODE_FK_PK;
                    Log::info('Schéma posologique num :' . $schéma_id);
                    $i = count($schemas_poso);
                    $j = count($groupes); //pour sortir des 2 boucle i et j
                }
            } //END LOOP GROUPS
            Log::info('FIN parcours des groupes de terrains.');

            // 4 - grace à l'identifiant du schéma posologie on recherche dans la table ipo_info_poso : frequence max journalière (ipo_freqmax) , dose max liée au terrain
            if ($schéma_id != "") {
                Log::info('Resortir table(ipo_infoposo) , ipo_fpo_code_fk_pk:' . $schéma_id . '...');
                // 4 - grace à l'identifiant du schéma posologie on recherche dans la table ipo_info_poso : frequence max journalière (ipo_freqmax) , dose max liée au terrain
                $ligne_dose = DB::table("ipo_infoposo")
                    ->select()
                    ->where("ipo_cdf_napo_code_fk", '02')
                    ->where('ipo_fpo_code_fk_pk', $schéma_id)
                    ->get(); // le 02 signifie les dose maximals       
                //ADAPTER EN THERIAQUE C4EST UN POINT
                Log::info('Colonnes resortis : freq_max, dose_max.');
                // 5 - la fréquence max récuperer , on compare avec la dose journalière prescrit
                // 5.1 - si dépasse alors retourner une alerte , sinon on passe au médicament suivant  

                if (count($ligne_dose) > 0 && $ligne_dose[0]->IPO_FREQMAX != '.') {

                    if ($dose_journ > $ligne_dose[0]->IPO_FREQMAX) {
                        Log::info('Verfication dose spécialite(' . $dose_journ . ') > freq_max(' . $ligne_dose[0]->IPO_FREQMAX . ')');
                        Log::info("flag = " . $flag);
                        if ($flag == '1') { // traitement pour le cas d'analyse pharmaceutique
                            if ($ligne_dose['0']->IPO_CDF_FREQMIN_CODE_FK != "null")
                                $unit_freqMin = DB::table('cdf_codif')->select('cdf_nom')->where('cdf_code_pk', $ligne_dose[0]->IPO_CDF_FREQMIN_CODE_FK)->where("cdf_numero_pk", 'PF')->get();

                            if ($ligne_dose[0]->IPO_CDF_FREQMAX_CODE_FK != "null")
                                $unit_freqMax = DB::table('cdf_codif')->select('cdf_nom')->where('cdf_code_pk', $ligne_dose[0]->IPO_CDF_FREQMAX_CODE_FK)->where("cdf_numero_pk", 'PF')->get();

                            if ($ligne_dose[0]->IPO_CDF_UNPO_CODE_FK != "null")
                                $unit_doseMax = DB::table('cdf_codif')->select('cdf_nom')->where('cdf_code_pk', $ligne_dose[0]->IPO_CDF_UNPO_CODE_FK)->where("cdf_numero_pk", 'PP')->get();

                            $surdosage_array = array(
                                "unite"        => ((isset($unit_doseMax[0]->cdf_nom)) ?  $unit_doseMax[0]->cdf_nom : ""),
                                "uniteFreqMin" => ((isset($unit_freqMin[0]->cdf_nom)) ?  $unit_freqMin[0]->cdf_nom : ""),
                                "uniteFreqMax" => ((isset($unit_freqMax[0]->cdf_nom)) ?  $unit_freqMax[0]->cdf_nom : ""),
                                "dose"         => $ligne_dose[0]->IPO_DOSEMAX,
                                "dosePatient"  => $dose_journ,
                                "unitePatient"  => $ligne->unite,
                                "freqMin"      => $ligne_dose[0]->IPO_FREQMIN,
                                "freqMax"      => $ligne_dose[0]->IPO_FREQMAX,
                                "durée"        => $ligne_dose[0]->IPO_DUREEMAX,
                                "profile"      => $type,
                                "clairance"    => $clairance
                            );
                            Log::info('Tableau de surdosage créer');
                            return $surdosage_array;
                        }

                        Log::info('Retourner Surdosage');
                        return false; // return surdosage to pre-analyse                            
                    }
                }
            }
        } //END LOOP FOR
        Log::info('Fin verification terrains posologique.');
        Log::info('Pas de surdosage.');
        return true;
    }

    /**
     * Retourne la redondance
     *
     * @return void
     * @author 
     **/
    protected function redondance($line, $nextLine)
    {

        // Check if there are not the same drugs
        if ($line->med_sp_id === $nextLine->med_sp_id) {
            return [
                "nom_sac_redondant" => $line->SP_NOM
            ];
        }

        $result_redondance = DB::select(
            "
                select DISTINCT t1.cosac_sp_code_fk_pk  idspe, 
                                t4.sp_nom               nom, 
                                t1.cosac_sac_code_fk_pk sac, 
                                t1.cosac_dosage         dose, 
                                t1.cosac_unitedosage    unite, 
                                t2.sac_nom              sac_nom 
                FROM   cosac_compo_subact t1, 
                       sac_subactive t2, 
                       cosac_compo_subact t3, 
                       sp_specialite t4 
                WHERE  t1.cosac_sac_code_fk_pk = t2.sac_code_sq_pk 
                       AND t1.cosac_sac_code_fk_pk = t3.cosac_sac_code_fk_pk 
                       AND t1.cosac_sp_code_fk_pk <> t3.cosac_sp_code_fk_pk 
                       AND t1.cosac_sp_code_fk_pk = t4.sp_code_sq_pk 
                       AND t1.cosac_sp_code_fk_pk IN ( ? ) 
                       AND t3.cosac_sp_code_fk_pk IN ( ? ) 
                UNION 
                SELECT DISTINCT t1.cosac_sp_code_fk_pk idspe, 
                                t4.sp_nom              nom, 
                                t2.sac_code_sq_pk      sac, 
                                t1.cosac_dosage        dose, 
                                t1.cosac_unitedosage   unite, 
                                t2.sac_nom             sac_nom 
                FROM   cosac_compo_subact t1, 
                       sac_subactive t2, 
                       sac_subactive t3, 
                       sp_specialite t4, 
                       cosac_compo_subact t5 
                WHERE  t1.cosac_sac_code_fk_pk = t2.sac_code_sq_pk 
                       AND t2.sac_gsac_code_fk = t3.sac_gsac_code_fk 
                       AND t1.cosac_sp_code_fk_pk <> t5.cosac_sp_code_fk_pk
                       AND t2.sac_code_sq_pk <> t3.sac_code_sq_pk 
                       AND t1.cosac_sp_code_fk_pk = t4.sp_code_sq_pk 
                       AND t5.cosac_sac_code_fk_pk = t3.sac_code_sq_pk 
                       AND t1.cosac_sp_code_fk_pk IN ( ? ) 
                       AND t5.cosac_sp_code_fk_pk IN ( ? )             
                ORDER BY 1 ,3 ",
            [$line->med_sp_id, $nextLine->med_sp_id, $line->med_sp_id, $nextLine->med_sp_id]
        );

        if (count($result_redondance) > 0) {
            $redondance_array = array(
                "nom_sac_redondant" => $result_redondance[0]->sac_nom
            );

            return $redondance_array;
        }
        return;
    }
    /**
     * Retourne les Interacations médicamenteuse entre médicaments A et B
     *
     * @return void
     * @author 
     **/
    protected function interaction_medicamenteuse($med_sp_id, $med_sp_id_next)
    {
        $codes = $codes_next = array();
        $code_dci = DB::table('cosac_compo_subact')
            ->select('cosac_sac_code_fk_pk')
            ->where('cosac_sp_code_fk_pk', $med_sp_id)
            ->get();
        $codes_dci_next = DB::table('cosac_compo_subact')
            ->select('cosac_sac_code_fk_pk')
            ->where('cosac_sp_code_fk_pk', $med_sp_id_next)
            ->get();

        foreach ($code_dci as $code)        $codes[]       =  $code->cosac_sac_code_fk_pk;
        foreach ($codes_dci_next as $code1) $codes_next[] =  $code1->cosac_sac_code_fk_pk;

        $codes_t     = implode(",", $codes); // LISTE DE CODE DCI MELANGES
        $codes_tnext = implode(",", $codes_next); // LISTE DE CODES DCI MELANGES
        Log::info("Médicaments DCI n01 : " . $codes_t . " .SP associé : " . $med_sp_id);
        Log::info("Médicaments DCI n02 : " . $codes_tnext . " .SP associé : " . $med_sp_id_next);

        Log::info("Lancement de verfication EIM entre DCS1 , DCIS2.....");
        foreach ($codes_dci_next as $code_dci_nxt) {
            $results = DB::select("
                    select 
                        t1.it1sac_fit_code_fk_pk as idinter, 
                        t5.cdf_nom as valide, 
                        t3.fitna_cdf_nait_code_fk_pk as niveau,
                        t6.sac_nom as sac_2
                    from 
                        it1sac_terme1subactive t1, 
                        it2sac_terme2subactive t2, 
                        fitna_interaction_nature t3, 
                        fitva_niveau_validation t4, 
                        cdf_codif t5 ,
                        sac_subactive t6
                        
                    WHERE 
                        t1.it1sac_fit_code_fk_pk = t2.it2sac_fit_code_fk_pk 
                        and t3.fitna_fit_code_fk_pk = t1.it1sac_fit_code_fk_pk 
                        and t4.fitva_fit_code_fk_pk = t1.it1sac_fit_code_fk_pk 
                        and t5.cdf_code_pk = t4.fitva_cdf_vait_code_fk_pk 
                        and t6.sac_code_sq_pk = t2.it2sac_sac_code_fk_pk  
                        and t4.fitva_cdf_vait_code_fk_pk = '1' 
                        and t5.cdf_numero_pk = 'IV' 
                        and t1.it1sac_sac_code_fk_pk <> t2.it2sac_sac_code_fk_pk 
                        and t1.it1sac_sac_code_fk_pk in (?) 
                        and t2.it2sac_sac_code_fk_pk in (?) 
                        and t3.fitna_cdf_nait_code_fk_pk <= 11
                        and exists 
                        ( 
                        select 
                            it1sac_fit_code_fk_pk , 
                            it1sac_sac_code_fk_pk 
                        from 
                            it1sac_terme1subactive 
                        where 
                            t2.it2sac_sac_code_fk_pk = it1sac_sac_code_fk_pk and 
                            t1.it1sac_fit_code_fk_pk = it1sac_fit_code_fk_pk )   
                        group by 
                            t1.it1sac_fit_code_fk_pk, 
                            t5.cdf_nom, 

                            t3.fitna_cdf_nait_code_fk_pk 
                        union 
                        select 
                            t1.it1sac_fit_code_fk_pk as idinter , 
                            t5.cdf_nom as valide , 


                            t3.fitna_cdf_nait_code_fk_pk as niveau,
                            t6.sac_nom as sac_2
                        from 
                            it1sac_terme1subactive t1, 
                            it2sac_terme2subactive t2, 
                            fitna_interaction_nature t3, 
                            fitva_niveau_validation t4, 
                            cdf_codif t5 , sac_subactive t6

                        WHERE 
                            t1.it1sac_fit_code_fk_pk = t2.it2sac_fit_code_fk_pk and 
                            t3.fitna_fit_code_fk_pk = t1.it1sac_fit_code_fk_pk and 
                            t4.fitva_fit_code_fk_pk = t1.it1sac_fit_code_fk_pk and 
                            t5.cdf_code_pk = t4.fitva_cdf_vait_code_fk_pk and 
                            t6.sac_code_sq_pk = t2.it2sac_sac_code_fk_pk and
                            t4.fitva_cdf_vait_code_fk_pk = '1' and 
                            t5.cdf_numero_pk = 'IV' and 
                            t1.it1sac_sac_code_fk_pk <> t2.it2sac_sac_code_fk_pk and 
                            t1.it1sac_sac_code_fk_pk in (?) and 
                            t2.it2sac_sac_code_fk_pk in (?) and 
                            t3.fitna_cdf_nait_code_fk_pk <= 4 and 
                            not exists ( 
                            select 
                                it1sac_fit_code_fk_pk , 
                                it1sac_sac_code_fk_pk from it1sac_terme1subactive 
                            where 
                                t2.it2sac_sac_code_fk_pk = it1sac_sac_code_fk_pk and 
                                t1.it1sac_fit_code_fk_pk = it1sac_fit_code_fk_pk ) 
                        order by 1; ", [$codes_t, $codes_tnext, $codes_t, $codes_tnext]);


            if (count($results) > 0) { // if there is interactions
                Log::warning('DETECTION EIM entre :' . $codes_t . " , " . $codes_tnext);
                Log::info("Creation du tableau intercation médicamenteuse....");
                foreach ($results as $result) {
                    $fiche     = $this->getFicheInteraction($result->idinter);
                    $mecanisme = $this->getMecanisme($result->idinter);
                    $i_array[] = array(
                        //"item_sac_1" => $result->sac_1,
                        "item_sac_2"        => $result->sac_2,
                        "niveau_inter"      => $result->niveau,
                        "mecanisme"         => $mecanisme,
                        "fiche_interaction" => $fiche[0]->nofit
                    );
                }
                Log::info("Tableau EIM créer!");
                return $i_array;
            }
        }
        Log::info("*********FIN Lancement de verfication EIM entre DCS1 , DCIS2***********");
        Log::info("EIM INTROUVABLE!");
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function interaction_sp_medicamenteuse($med_sp_id, $med_sp_id_next)
    {
        $results = DB::select("select 
                    t1.it1sp_fit_code_fk_pk as idinter, 
                    t5.cdf_nom as valide, 
                    case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t6.sp_nom else t7.sp_nom end as terme_1 , 
                    case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t7.sp_nom else t6.sp_nom end as terme_2 , 
                    case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t1.it1sp_sp_code_fk_pk else t2.it2sp_sp_code_fk_pk end as id_t1 , 
                    case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t2.it2sp_sp_code_fk_pk else t1.it1sp_sp_code_fk_pk end as id_t2 , 
                    t3.fitna_cdf_nait_code_fk_pk as niveau 
                from 
                    it1sp_terme1specialite t1, 
                    it2sp_terme2specialite t2, 
                    fitna_interaction_nature t3, 
                    fitva_niveau_validation t4, 
                    cdf_codif t5, sp_specialite t6, 
                    sp_specialite t7 
                WHERE 
                    t1.it1sp_fit_code_fk_pk = t2.it2sp_fit_code_fk_pk 
                    and t3.fitna_fit_code_fk_pk = t1.it1sp_fit_code_fk_pk 
                    and t4.fitva_fit_code_fk_pk = t1.it1sp_fit_code_fk_pk 
                    and t5.cdf_code_pk = t4.fitva_cdf_vait_code_fk_pk 
                    and t6.sp_code_sq_pk = t1.it1sp_sp_code_fk_pk 
                    and t7.sp_code_sq_pk = t2.it2sp_sp_code_fk_pk 
                    and t4.fitva_cdf_vait_code_fk_pk = '1' 
                    and t5.cdf_numero_pk = 'IV' 
                    and t1.it1sp_sp_code_fk_pk <> t2.it2sp_sp_code_fk_pk 
                    and t1.it1sp_sp_code_fk_pk in (?) 
                    and t2.it2sp_sp_code_fk_pk in (?) 
                    and t3.fitna_cdf_nait_code_fk_pk <= 4
                    and exists 
                    ( 
                    select 
                        it1sp_fit_code_fk_pk , 
                        it1sp_sp_code_fk_pk 
                    from 
                        it1sp_terme1specialite 
                    where 
                        t2.it2sp_sp_code_fk_pk = it1sp_sp_code_fk_pk and 
                        t1.it1sp_fit_code_fk_pk = it1sp_fit_code_fk_pk )     
                    group by 
                        t1.it1sp_fit_code_fk_pk, 
                        t5.cdf_nom, 
                        case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t6.sp_nom else t7.sp_nom end , 
                        case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t7.sp_nom else t6.sp_nom end , 
                        case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t1.it1sp_sp_code_fk_pk else t2.it2sp_sp_code_fk_pk end , 
                        case when t1.it1sp_sp_code_fk_pk < t2.it2sp_sp_code_fk_pk then t2.it2sp_sp_code_fk_pk else t1.it1sp_sp_code_fk_pk end , 
                        t3.fitna_cdf_nait_code_fk_pk 
                    union 
                    select 
                        t1.it1sp_fit_code_fk_pk as idinter , 
                        t5.cdf_nom as valide , 
                        t6.sp_nom as terme_1 , 
                        t7.sp_nom as terme_2 , 
                        t1.it1sp_sp_code_fk_pk as id_t1 , 
                        t2.it2sp_sp_code_fk_pk as id_t2 , 
                        t3.fitna_cdf_nait_code_fk_pk as niveau 
                    from 
                        it1sp_terme1specialite t1, 
                        it2sp_terme2specialite t2, 
                        fitna_interaction_nature t3, 
                        fitva_niveau_validation t4, 
                        cdf_codif t5, 
                        sp_specialite t6, 
                        sp_specialite t7 
                    WHERE 
                        t1.it1sp_fit_code_fk_pk = t2.it2sp_fit_code_fk_pk and 
                        t3.fitna_fit_code_fk_pk = t1.it1sp_fit_code_fk_pk and 
                        t4.fitva_fit_code_fk_pk = t1.it1sp_fit_code_fk_pk and 
                        t5.cdf_code_pk = t4.fitva_cdf_vait_code_fk_pk and 
                        t6.sp_code_sq_pk = t1.it1sp_sp_code_fk_pk and 
                        t7.sp_code_sq_pk = t2.it2sp_sp_code_fk_pk and 
                        t4.fitva_cdf_vait_code_fk_pk = '1' and 
                        t5.cdf_numero_pk = 'IV' and 
                        t1.it1sp_sp_code_fk_pk <> t2.it2sp_sp_code_fk_pk and 
                        t1.it1sp_sp_code_fk_pk in (?) and 
                        t2.it2sp_sp_code_fk_pk in (?) and 
                        t3.fitna_cdf_nait_code_fk_pk <= 4 and 
                        not exists ( 
                        select 
                            it1sp_fit_code_fk_pk , 
                            it1sp_sp_code_fk_pk from it1sp_terme1specialite 
                        where 
                            t2.it2sp_sp_code_fk_pk = it1sp_sp_code_fk_pk and 
                            t1.it1sp_fit_code_fk_pk = it1sp_fit_code_fk_pk ) 
                    order by 1", [$med_sp_id, $med_sp_id_next, $med_sp_id, $med_sp_id_next]);

        if (count($results) > 0) //if there is interaction
        {
            Log::warning('DETECTION EIM entre :' . $med_sp_id . " , " . $med_sp_id_next);
            Log::info("Creation du tableau intercation médicamenteuse....");
            $terme_2 = $this->getDCIS($med_sp_id_next);
            foreach ($results as $result) {
                $fiche  = $this->getFicheInteraction($result->idinter);
                $mecanisme = $this->getMecanisme($result->idinter);

                $i_array = array(
                    "item_sac_1" => $med_sp_id,
                    "item_sac_2" => $terme_2,
                    "niveau_inter" => $result->niveau,
                    "mecanisme"         => $mecanisme,
                    "fiche_interaction" => $fiche[0]->nofit
                );
            }
            Log::info("Tableau EIM créer!");
            return $i_array;
        }
        Log::info("************FIN Lancement de verfication EIM entre SP1 , SP2**************");
        Log::info("EIM INTROUVABLE!");
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function getFicheInteraction($idinters)
    {
        //resortir la fiche interaction pour chaque niveau d'interaction 
        $fiche = DB::select("select   
                            fit_texte as nofit
                            from 
                            fit_ficheinterac
                            where    
                            fit_code_sq_pk in (?)
                            order by 
                            fit_code_sq_pk", [$idinters]);
        return $fiche;
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function getMecanisme($idinters)
    {
        $tab = array();
        //resortir la fiche interaction pour chaque niveau d'interaction 
        $mecanisme = DB::select("select  
            t1.fitty_fit_code_fk_pk         as nofic ,    
            t2.cdf_nom                      as info_01

            from   fitty_typeinteraction          t1,               
                   cdf_codif                      t2                
            where  t1.fitty_fit_code_fk_pk       in (?)  
            and    t1.fitty_cdf_type_code_fk_pk  = t2.cdf_code_pk   
            and    t2.cdf_numero_pk              = 'IY'     ", [$idinters]);

        foreach ($mecanisme as $val) {
            $tab[] = $val->info_01;
        }
        $mecanismes = implode(' - ', $tab);
        return $mecanismes;
    }
    /**
     * retourne les interactions alimentaire
     * entre médicaments et produits alimentaires
     * @return void
     * @author 
     **/
    protected function interaction_alimentaire($med_sp_id, $phyto_patient, $flag)
    {
        $infos = array();
        //resortir le(s) médicament(s) DCI du médicament spécialité de la ligne prescription
        $result_dci = DB::table('cosac_compo_subact')
            ->select('cosac_sac_code_fk_pk')
            ->where('cosac_sp_code_fk_pk', $med_sp_id)
            ->get();
        foreach ($phyto_patient as $phyto) {
            foreach ($phyto->produit->interactions as $interaction) {
                // dd($phyto->produit->produit_naturel_fr);
                foreach ($result_dci as $code_dci) {
                    if ($interaction->sac_subactive_id === $code_dci->cosac_sac_code_fk_pk) {
                        if ($flag === '1') { // retourner pour l'analyse pharmaceutique
                            $infos[] = array(
                                "aliment"    => $phyto->produit->produit_naturel_fr . ($phyto->produit->produits_arabe ? "( " . $phyto->produit->produits_arabe . " )"  : ""),
                                "type_effet" => $interaction->type_effet,
                                "effet"      => $interaction->effet_interaction,
                                "niveau"     => $interaction->niveau,
                                "indication"     => $interaction->indication,
                                "effet_pharmaco"     => $interaction->effet_pharmaco,
                                "recommendation"     => $interaction->recommendation,
                            );
                            // return $infos;
                        }
                        // return;
                    } //! End If
                } //! End Foreach DCI
            } //! End Foreach Interactions
        } //! End Foreach Phytos Patient
        return $infos;
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function test_interaction_alimentaire($med_sp_id, $phyto_patient)
    {
        $phyto_boolean = $this->interaction_alimentaire($med_sp_id, $phyto_patient, '1');
        if ($phyto_boolean != null) {

            return $phyto_boolean;
        }
        return;
    }
    /**
     * Retourne précaution d'emploi
     *
     * @return void
     * @author 
     **/
    protected function get_pe($med_sp, $pat_allergie, $path_pat, $pat_etat)
    {
        $allergie_array = array();
        $pathologie_array = array();
        $pe_and_ci      = DB::select("select  
                t3.cdf_nom  , 
                t5.NIVCOM_CDF_COM_CODE_FK_PK as niveau ,
                t5.NIVCOM_CDF_TER_CODE_FK_PK as ter_comment ,
                t5.NIVCOM_FCPM_CODE_FK_PK as code_fiche
                FROM  fcpmsp_cipemg_spe T1, cdf_codif t3 ,nivcom_niveau_commentaire t5
                WHERE t5.NIVCOM_FCPM_CODE_FK_PK = T1.FCPMSP_FCPM_CODE_FK_PK 
                and t3.cdf_code_pk=t5.nivcom_cdf_ter_code_fk_pk
                and t5.NIVCOM_CDF_COM_CODE_FK_PK ='X1' 
                AND T1.FCPMSP_SP_CODE_FK_PK       = ?
                ORDER BY 1 ", [$med_sp]);

        foreach ($pe_and_ci as $pe_ci) {
            // test si le profile patient représente des cas de précaution d'emploi resortis dans la variable $pe_and_ci
            $allergie_array_tmp   = $this->get_allergie_sp_patient($med_sp, $pe_ci, $pat_allergie, "Précaution d'emploi");
            $pathologie_array_tmp = $this->get_pathologie_sp_patient($med_sp, $pe_ci, $path_pat, "Précaution d'emploi");

            if ($allergie_array_tmp)
                $allergie_array[] = $allergie_array_tmp;
            if ($pathologie_array_tmp)
                $pathologie_array[] = $pathologie_array_tmp;
            if ($pat_etat == "grossesse" && $pe_ci->cdf_nom == "GROSSESSE") { // precautin d'emploi pour grossesse
                $grossesse = "Grossesse";
            }
            // if ($pat_etat == "alaitement" && $pe_ci->cdf_nom == "ALLAITEMENT") { // precautin d'emploi pour grossesse
            //     $allaitement = "Allaitement";
            // }
        }
        if (isset($grossesse))
            $pathologie_array[] = [
                'pathologie' => $grossesse
            ];
        if (isset($allaitement))
            $pathologie_array[] = [
                'pathologie' => $allaitement
            ];
        return array_merge($allergie_array, $pathologie_array);
    }
    /**
     * Get Contre Indications par apport au profil patient
     *
     * @param int $med_sp
     * @param array $pat_allergie
     * @param array $path_pat Pathologies du Patients
     * @param string $pat_etat Patiente en grossesse ou allaitement 
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return array
     */
    protected function get_ci($med_sp, $pat_allergie, $path_pat, $pat_etat)
    {
        $allergie_array = array();
        $pathologie_array = array();
        $pe_and_ci = DB::select(" select  
            t3.cdf_nom  , 
            t5.NIVCOM_CDF_COM_CODE_FK_PK as niveau ,
            t5.NIVCOM_CDF_TER_CODE_FK_PK as ter_comment ,
            t5.NIVCOM_FCPM_CODE_FK_PK as code_fiche
            FROM   fcpmsp_cipemg_spe T1, cdf_codif t3 ,nivcom_niveau_commentaire t5
            WHERE t5.NIVCOM_FCPM_CODE_FK_PK = T1.FCPMSP_FCPM_CODE_FK_PK 
            and t3.cdf_code_pk=t5.nivcom_cdf_ter_code_fk_pk
            and  t5.NIVCOM_CDF_COM_CODE_FK_PK ='X9'
            AND T1.FCPMSP_SP_CODE_FK_PK       = ?
            ORDER BY 1 ", [$med_sp]);

        foreach ($pe_and_ci as $pe_ci) // pour chaque fiche
        {
            $allergie_array_tmp    = $this->get_allergie_sp_patient($med_sp, $pe_ci, $pat_allergie, "Contre indication");
            $pathologie_array_tmp  = $this->get_pathologie_sp_patient($med_sp, $pe_ci, $path_pat, "Contre indication");

            if ($allergie_array_tmp)
                $allergie_array[] = $allergie_array_tmp;
            if ($pathologie_array_tmp)
                $pathologie_array[] = $pathologie_array_tmp;
            if ($pat_etat == "grossesse" && $pe_ci->cdf_nom == "GROSSESSE") { // precautin d'emploi pour grossesse
                $grossesse = "Grossesse";
            }
            // if ($pat_etat == "alaitement" && $pe_ci->cdf_nom == "ALLAITEMENT") { // precautin d'emploi pour grossesse
            //     $allaitement = "Allaitement";
            // }
        }
        if (isset($grossesse))
            $pathologie_array[] = [
                'pathologie' => $grossesse
            ];
        if (isset($allaitement))
            $pathologie_array[] = [
                'pathologie' => $allaitement
            ];
        return array_merge($allergie_array, $pathologie_array);
    }
    /**
     * Retourne les associations déconseillés
     *
     * @return void
     * @author 
     **/
    protected function get_ad($med_sp, $pat_allergie, $path_pat, $pat_etat)
    {
        $allergie_array = array();
        $pathologie_array = array();
        $pe_and_ci = DB::select(" select  
            t3.cdf_nom  , 
            t5.NIVCOM_CDF_COM_CODE_FK_PK as niveau ,
            t5.NIVCOM_CDF_TER_CODE_FK_PK as ter_comment ,
            t5.NIVCOM_FCPM_CODE_FK_PK as code_fiche
            FROM   fcpmsp_cipemg_spe T1, cdf_codif t3 ,nivcom_niveau_commentaire t5
            WHERE t5.NIVCOM_FCPM_CODE_FK_PK = T1.FCPMSP_FCPM_CODE_FK_PK 
            and t3.cdf_code_pk=t5.nivcom_cdf_ter_code_fk_pk
            and  t5.NIVCOM_CDF_COM_CODE_FK_PK ='X14'
            AND T1.FCPMSP_SP_CODE_FK_PK       = ?
            ORDER BY 1 ", [$med_sp]); // 'X14' : Utilisation déconseillé

        foreach ($pe_and_ci as $pe_ci) // pour chaque fiche
        {

            $allergie_array_tmp    = $this->get_allergie_sp_patient($med_sp, $pe_ci, $pat_allergie, null);
            $pathologie_array_tmp  = $this->get_pathologie_sp_patient($med_sp, $pe_ci, $path_pat, null);

            if ($allergie_array_tmp)
                $allergie_array[] = $allergie_array_tmp;
            if ($pathologie_array_tmp)
                $pathologie_array[] = $pathologie_array_tmp;

            if ($pat_etat == "grossesse" && $pe_ci->cdf_nom == "GROSSESSE") { // precautin d'emploi pour grossesse
                $grossesse = "Grossesse";
            }
            // if ($pat_etat == "alaitement" && $pe_ci->cdf_nom == "ALLAITEMENT") { // precautin d'emploi pour grossesse
            //     $allaitement = "Allaitement";
            // }
        }
        if (isset($grossesse))
            $pathologie_array[] = [
                'pathologie' => $grossesse
            ];
        if (isset($allaitement))
            $pathologie_array[] = [
                'pathologie' => $allaitement
            ];
        return array_merge($allergie_array, $pathologie_array);
    }
    /**
     * return allergies of meds
     *
     * @return array
     * @author 
     **/
    protected function allergies($med_sp, $ficheid)
    {
        $result =  DB::select(" select distinct(t2.TERCOM_CDF_COM_CODE_FK_PK) as code_comment_terrain
                from fcpmsp_cipemg_spe t1 , tercom_terrain_commentaire t2 , nivcom_niveau_commentaire t4
            where
            t2.TERCOM_FCPM_CODE_FK_PK = t4.NIVCOM_FCPM_CODE_FK_PK
            and
            t4.NIVCOM_CDF_COM_CODE_FK_PK='X9'
            and
            t1.FCPMSP_FCPM_CODE_FK_PK = t4.NIVCOM_FCPM_CODE_FK_PK
            and
            t1.FCPMSP_SP_CODE_FK_PK = ?
            and 
            t2.TERCOM_CDF_TER_CODE_FK_PK='ab5' 
            and t2.tercom_fcpm_code_fk_pk = ? ", [$med_sp, $ficheid]); // ab5 code terrain pour les hypersensibilités
        return $result;
    }
    /**
     * test if allergie of patient correspond to terrain comment
     * return the allergie of patient , or null
     * @return array
     * @author Sidou_White_Salaf
     **/
    protected function get_allergie_sp_patient($med_sp, $pe_ci, $pat_allergie, $niveau)
    {
        $allergies_med_sp = array();
        $allergie_array = null;
        if ($pe_ci->cdf_nom === "HYPERSENSIBILITE") {
            if ($pat_allergie != null) {
                //resortir les type d'hypersensibilité qui existe pour une fiche donné
                $allergies_med_sp = $this->allergies($med_sp, $pe_ci->code_fiche); // retoure les code commentraire terrain

                foreach ($pat_allergie as $p_allergie) //pour chaque allergie du patient , on test si il est présent dans la fiche de niveau PE     
                    foreach ($allergies_med_sp as $allergie)
                        if ($p_allergie->id === $allergie->code_comment_terrain) {
                            // Si l'allergie existe bien dans la fiche PE ?
                            // créer un tableau contenant :
                            // medicament_sp_id , niveau : PE , type hypersensisibilité 
                            $allergie_array = array(
                                //  "med_sp_id" => $med_sp , 
                                //"niveau"    => $niveau,
                                "hypersensibilité" => $p_allergie->allergie
                            );
                        }
            }
            // print_r($allergie_array);
        }
        return $allergie_array;
    }
    /**
     * undocumented function
     *
     * @return null
     * @author 
     **/
    protected function get_pathologie_sp_patient($med_sp, $pe_ci, $path_pat, $niveau)
    {
        $pathologies_array = null;
        if ($path_pat != null) {
            foreach ($path_pat as $path) { // test par rapport à la pathologie
                if ($pe_ci->cdf_nom  === $path->pathologie) {

                    // Si la pathologie existe bien dans la fiche CI ?
                    // créer un tableau contenant :
                    // medicament_sp_id , niveau : CI , type hypersensisibilité 
                    $pathologies_array = array(
                        //"med_sp_id" => $med_sp , 
                        //"niveau"    => $niveau,
                        "pathologie" => $path->pathologie
                    );
                }
            }
        } //si le patient à des pathologies
        return $pathologies_array;
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function getDCIS($dci_code)
    {
        $dci = "";
        $resultats = DB::table('cosac_compo_subact')
            ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
            ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
            ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $dci_code)
            ->get();

        foreach ($resultats as $keys => $resultat)
            $dci .= $resultat->sac_nom . " " . $resultat->cosac_dosage . $resultat->cosac_unitedosage . (($keys == (count($resultats) - 1)) ? '.' : '/');

        return $dci;
    }
    /**
     * convertir l'age en jours / mois / semaines
     *
     * @return void
     * @author 
     **/
    protected function convert($age, $to)
    {
        switch ($to) {
            case 'j':
                $conv = $age * 365;
                break;
            case 's':
                $conv = $age * 52;
                break;
            case 'm':
                $conv = $age * 12;
                break;

            default:
                # code...
                break;
        }
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function compareMesure($unit, $age, $poids)
    {
        switch ($unit) {
            case 'ans':
                return  $age;
            case 'jours':
                return  $this->convert($age, 'j');
            case 'mois':
                return  $this->convert($age, 'm');
                break;
            case 'semaines':
                return  $this->convert($age, 's');
            case 'kg':
                if ($poids != "")
                    return  $poids;
                break;
            default:
                return;
        }
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function type_age($d_naissance)
    {
        $age = intval(date('Y/m/d', strtotime("now"))) - intval(date('Y/m/d', strtotime($d_naissance)));
        if ($age == 0) $type = "NOUVEAU-NE";
        else if ($age <= 2) $type = "NOURRISSON";
        else if ($age > 2 and $age <= 18) $type = "ENFANT";
        else $type = "ADULTE";
        return $type;
    }
    /**
     * Calcule de la clairance
     *
     * @param String $sexe M/F
     * @param Integer $poids 
     * @param Integer $age l'age du patient en années
     * @param Float $creat créatinine du patient en µmol/L
     * @param Integer|NULL $enceinte Si la femme est enceinte
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function calcul_clr($taille, $sexe, $poids, $age, $creat, $enceinte)
    {
        if ($age > 65 || $this->masseCorporel($poids, $taille) > 30 || $enceinte)
            return $this->formuleMDRD($sexe, $age, $creat);

        if ($age <= 21)
            return $this->formuleSchwartz($sexe, $taille, $age, $creat);

        return $this->formuleCockcroftAndGault($sexe, $poids, $age, $creat);
    }

    /**
     * Calcule de la clairance Formule MDRD 
     * {\displaystyle Cl\ cr=186.3*{\text{(creat*0.0113)}}^{-1.154}*{\text{age}}^{-0.203}*(*0.742\ {\text{si femme}})\ ml/min/{1.73m^{2}}}
     * @param [type] $sexe 
     * @param [type] $age âge en années.
     * @param [type] $creat créatininémie en µmol/L
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine en mL/min/1.73m2 ;
     */
    private function formuleMDRD($sexe,  $age, $creat)
    {
        if ($sexe == "F")
            return 186 * pow(($creat * 0.0113), -1.154) * pow($age, -0.203) * 0.742;
        else
            return 186 * pow(($creat * 0.0113), -1.154) * pow($age, -0.203);
    }
    /**
     * Calcule de la clairance Formule Shwartz pour enfants
     *
     * @param [type] $sexe
     * @param [type] $taille taille du patient en cm
     * @param [type] $age
     * @param [type] $creat
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine en mL/min/1.73m2 ;
     */
    private function formuleSchwartz($sexe, $taille, $age, $creat)
    {
        if ($age == 0) $k = 29; //* nouveau-né prématuré
        else if ($age <= 1) $k = 40;
        else if ($age >= 2 || $age <= 12) $k = 49; //* enfants de 2 à 12 ans
        else if ($sexe == "F" && ($age >= 13 || $age <= 21)) $k = 49; //* filles de 13 à 21 ans
        else if ($sexe == "M" && ($age >= 13 || $age <= 21)) $k = 62; //* garçons de 13 à 21 ans

        return  $k * $taille / $creat;
    }
    /** 
     * Calcule Clairance formule  Cockcroft And Gault
     *
     * @param [type] $sexe
     * @param [type] $poids
     * @param [type] $age
     * @param [type] $creat
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine
     */
    private function formuleCockcroftAndGault($sexe, $poids, $age, $creat)
    {
        if ($sexe == "M")
            return ((140 - $age) / $creat) * $poids * 1.23;
        else
            return ((140 - $age) / $creat) * $poids * 1.04;
    }
    /**
     * Caclule de la masse Corporel
     *
     * @param [type] $poids
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Integer massCorporel
     */
    public function masseCorporel($poids, $taille)
    {
        return $poids / pow($taille * 0.01, 2);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function test_bilans($patient, $regle)
    {
        foreach ($patient->bilansMax as $bilan)  // pour chaque bilan on test suivant la regle
            if ($regle->element === $bilan->element->element)  // si la regle correspond au bilan ex : k+ =k+
                if ($bilan->valeur < $regle->sup or $bilan->valeur > $regle->inf) { // si en dehors des intervalle du min et du max de la regle en question

                    return false;
                }
        return true;
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function analyseInterne($regle, $patient, $prescription)
    {

        //liste de tous les examens existant dans la BDD 
        $liste_examens_req =  DB::select("select element,unite from elements ");
        $elements_regle = explode(" ", $regle);
        $liste_examens[] = "";
        $n = 0;
        foreach ($liste_examens_req as $list => $liste_examens_req) {
            $liste_examens[$n] = $liste_examens_req->element . " (" . $liste_examens_req->unite . ")";
            $n++;
        }

        //le resultat retourné par cette fonction 
        $result = "";


        switch ($elements_regle[0]) {
            case "Age(ans)":
                //recuperer l'age du patient
                $age_patient = intval(date('Y/m/d', strtotime("now"))) - intval(date('Y/m/d', strtotime($patient->date_naissance)));
                $operation = $elements_regle[1];
                $age_regle = $elements_regle[2];
                if ($operation == "=") {
                    if ($age_patient == $age_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($age_patient <= $age_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($age_patient >= $age_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($age_patient >= $age_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($age_patient > $age_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($age_patient < $age_regle) $result = 1;
                    else  $result = 0;
                }
                break;
            case "Taille(cm)":
                $taille_patient = $patient->taille;
                $operation = $elements_regle[1];
                $taille_regle = $elements_regle[2];
                if ($operation == "=") {
                    if ($taille_patient  == $taille_regle) 1;
                    else $result = 0;
                } else if ($operation == "<=") {
                    if ($taille_patient  <= $taille_regle) $result = 1;
                    else $result = 0;
                } else if ($operation == ">=") {
                    if ($taille_patient  >= $taille_regle) $result = 1;
                    else $result = 0;
                } else if ($operation == "!=") {
                    if ($taille_patient  != $taille_regle) $result = 1;
                    else $result = 0;
                } else if ($operation == ">") {
                    if ($taille_patient > $taille_regle) $result = 1;
                    else $result = 0;
                } else if ($operation == "<") {
                    if ($taille_patient < $taille_regle) $result = 1;
                    else $result = 0;
                }
                break;
            case "Poids(kg)":
                //recuperer le poids du patient depuis la table element en étant un examen 
                $poids_result =  DB::select("select element,valeur,date_analyse from bilans,elements where element = 'Poids' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 2");
                $n = 1;
                $valeur[] = "";
                foreach ($poids_result as $poid => $poids_result) {
                    $valeur[$n] = $poids_result->valeur;
                    $n++;
                }
                //si le patient n'a pas encore fais d'examen du poids on prends sa valeur initiale $patient->poids
                if ($n > 2) {
                    $poids_patient = $valeur[1];
                } else  $poids_patient = $patient->poids;

                $operation = $elements_regle[1];
                $poids_regle = $elements_regle[2];
                if ($operation == "=") {
                    if ($poids_patient == $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($poids_patient <= $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($poids_patient >= $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($poids_patient != $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($poids_patient > $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($poids_patient < $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "+" || $operation == "-" || $operation == "/" || $operation == "*") {
                    $valeur_examen2 = "";
                    $k = 2;
                    $examen_nom_unite = "";
                    $examen_nom = "";
                    //dans cette boucle en récupérer le nom de chaque examen de la regle 
                    while (substr($elements_regle[$k], 0, 1) != "(") {
                        $examen_nom = $examen_nom . " " . $elements_regle[$k];
                        $k++;
                    }
                    //l'element_regle[$k] contient l'unité de l'examen
                    $examen_nom_unite = $examen_nom . " " . $elements_regle[$k];
                    //array search retourne la position de l'élément trouver sinon elle retourne false
                    $pos_ex = array_search($examen_nom_unite, $liste_examens);
                    if ($pos_ex == false) {
                        for ($y = 0; $y < count($liste_examens); $y++) {
                            //strtolower c'est pour rendre la chaine de caractére en miniscule 
                            $liste_examens[$y] = strtolower($liste_examens[$y]);
                        }
                        $pos_ex = array_search($examen_nom_unite, $liste_examens);
                    }
                    //le fonction ltrim c'est pour suprimer a partir le guache
                    $examen_nom = ltrim($examen_nom, " ");
                    $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $examen_nom . "' and unite ='" . trim($elements_regle[$k], "()") . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 1");
                    foreach ($examens as $examen => $examens) {
                        $valeur_examen2 = $examens->valeur;
                    }
                    if ($valeur_examen != null && $valeur_examen2 != null) {
                        if ($operation == "+") {
                            $result_opertation = $valeur_examen + $valeur_examen2;
                        } else if ($operation == "-") {
                            $result_opertation = $valeur_examen - $valeur_examen2;
                        } else if ($operation == "/") {
                            $result_opertation = $valeur_examen / $valeur_examen2;
                        } else if ($operation == "*") {
                            $result_opertation = $valeur_examen * $valeur_examen2;
                        }

                        if ($elements_regle[$k + 1] == "=") {
                            if ($elements_regle[$k + 2] == $result_opertation) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "<=") {
                            if ($result_opertation <= $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == ">=") {
                            if ($result_opertation >= $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "!=") {
                            if ($result_opertation != $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == ">") {
                            if ($result_opertation > $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "<") {
                            if ($result_opertation < $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        }
                    } else $result = 0;
                }
                break;
            case "Sexe":
                $sexe_regle = $elements_regle[2];
                $sexe_patient = $patient->sexe;
                if ($sexe_patient == "F") $sexe_patient = "Femme";
                else $service_patient = "Homme";
                if ($sexe_regle == $sexe_patient) $result = 1;
                else $result = 0;
                break;
            case "Mode":
                $tabagiste = $patient->tabagiste;
                $tabagiste_depuis = $patient->tabagiste_depuis;
                $alcoolique = $patient->alcoolique;
                $alcoolique_depuis = $patient->alcoolique_depuis;
                $drogue = $patient->drogue;
                $drogue_depuis = $patient->drogue_depuis;

                $operation = $elements_regle[1];
                $mode_regle[] = "";
                $i = 0;
                $n = 0;
                $et = false;
                $condition[] = "";
                $condition_mode = "";
                //la position de l'accolade a supprimer de la regle pour eviter de supp dautre accolades
                for ($x = 5; $x < count($elements_regle); $x++) {
                    $condition_mode = $condition_mode . $elements_regle[$x];
                    if ($elements_regle[$x] == "}") break;
                }
                //décomposer la régle par rapport ; ou / en supprimant } dans la condition_mode
                if (strchr($condition_mode, ";")) {
                    $et = true;
                    $mode_regle = explode(";", trim($condition_mode, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                } else
                    $mode_regle = explode("/", trim($condition_mode, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  

                for ($x = 0; $x < count($mode_regle); $x++)
                    $mode_regle[$x] = str_replace(' ', '', $mode_regle[$x]);
                if (in_array("Tabac", $mode_regle)) {
                    if ($tabagiste == "on") {
                        $condition[$n] = 1;
                        $n++;
                    } else {
                        $condition[$n] = 0;
                        $n++;
                    }
                }
                if (in_array("Alcool", $mode_regle)) {
                    if ($alcoolique == "on") {
                        $condition[$n] = 1;
                        $n++;
                    } else {
                        $condition[$n] = 0;
                        $n++;
                    }
                }
                if (in_array("Drogue", $mode_regle)) {
                    if ($drogue == "on") {
                        $condition[$n] = 1;
                        $n++;
                    } else {
                        $condition[$n] = 0;
                        $n++;
                    }
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
                // return $condition[0]."regle".$mode_regle[0]."-".$mode_regle[1]."taba".$tabagiste."et".$et;
                break;
            case "Pathologie(s)":
                $pathologies_patient[] = "";
                $n = 1;
                $pathologies =  DB::select("select distinct pathologie from  pathologies,pathologie_patient where pathologies.id = pathologie_patient.pathologie_id and patient_id=" . $patient->id);
                foreach ($pathologies as $pat => $pathologies) {
                    $pathologies_patient[$n] = $pathologies->pathologie;
                    $n++;
                }
                $et = false;
                $condition_pathologie = "";
                $pathologies_regle[] = "";
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        $condition_pathologie = $condition_pathologie . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                    if (strchr($condition_pathologie, ";")) {
                        $et = true;
                        $pathologies_regle = explode(";", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $pathologies_regle = explode("/", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($pathologies_regle); $y++) {
                        $pathologies_regle[$y] = str_replace(' ', '', $pathologies_regle[$y]);
                        $pos = array_search($pathologies_regle[$y], $pathologies_patient);
                        if ($pos != false) {
                            $condition[$y] = 1;
                        } else $condition[$y] = 0;
                    }
                } else {
                    $pathologies_regle = $elements_regle[3];
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
                break;
            case "Allergie(s)":
                $allegries_patient[] = "";
                $n = 1;
                $allegries =  DB::select("select distinct allergie from  allergies,allergie_patient where allergies.id = allergie_patient.allergie_id and patient_id=" . $patient->id);
                foreach ($allegries as $alr => $allegries) {
                    $allegries_patient[$n] = str_replace(' ', '', $allegries->allergie);
                    $n++;
                }
                $condition_allergie = "";
                $allegries_regle[] = "";
                $et = false;
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        $condition_allergie = $condition_allergie . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                    if (strchr($condition_allergie, ";")) {
                        $et = true;
                        $allegries_regle = explode(";", trim($condition_allergie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $allegries_regle = explode("/", trim($condition_allergie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($allegries_regle); $y++) {
                        $allegries_regle[$y] = str_replace(' ', '', $allegries_regle[$y]);
                        $pos = array_search($allegries_regle[$y], $allegries_patient);
                        if ($pos != false) {
                            $condition[$y] = 1;
                        } else $condition[$y] = 0;
                    }
                } else {
                    $allegries_regle = $elements_regle[3];
                    $pos = array_search($allegries_regle, $allegries_patient);
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
                break;
            case "Service":
                $hospitalisations =  DB::select("select service from hospitalisations where patient_id =" . $patient->id . " order by date_admission DESC");
                $operation = $elements_regle[1];
                $x = 2;
                $service_regle = "";
                $service_patient = "";

                while ($x < count($elements_regle)) {
                    if ($elements_regle[$x] == "ET" || $elements_regle[$x] == "OU") {
                        break;
                    }
                    $service_regle = $service_regle . " " . $elements_regle[$x];
                    $x++;

                    //if($x==3) return $service_regle."//".$elements_regle[$x+1];;

                }
                foreach ($hospitalisations as $hosp => $hospitalisations) {
                    $service_patient =  $hospitalisations->service;
                }
                $service_regle = str_replace(' ', '', $service_regle);
                $service_patient = str_replace(' ', '', $service_patient);
                if ($service_patient == $service_regle) $result = 1;
                else $result = 0;
                break;
            case "Durée":
                $operation = $elements_regle[2];
                $dureeHos_regle = $elements_regle[3];
                $dureeHos_patient = "";

                $hospitalisations =  DB::select("select date_admission,date_sortie from  hospitalisations where patient_id =" . $patient->id);
                foreach ($hospitalisations as $hosp => $hospitalisations) {
                    $debut = date_create($hospitalisations->date_admission);
                    $fin = date_create($hospitalisations->date_sortie);
                    $date_interval = date_diff($fin, $debut);
                    $dureeHos_patient = $date_interval->format('%d');
                }
                if ($operation == "=") {
                    if ($dureeHos_patient == $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($dureeHos_patient <= $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($dureeHos_patient >= $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($dureeHos_patient != $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($dureeHos_patient > $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($dureeHos_patient < $dureeHos_regle) $result = 1;
                    else  $result = 0;
                }
                break;
            case "Nombre":
                $operation = $elements_regle[4];
                $nombre_ligne_presc_regle = $elements_regle[5];
                $nombre_ligne_presc_patient = 0;
                foreach ($prescription->lignes as $ligne) {
                    $nombre_ligne_presc_patient++;
                }
                if ($operation == "=") {
                    if ($nombre_ligne_presc_patient == $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($nombre_ligne_presc_patient <= $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($nombre_ligne_presc_patient >= $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($nombre_ligne_presc_patient != $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($nombre_ligne_presc_patient > $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($nombre_ligne_presc_patient < $nombre_ligne_presc_regle) $result = 1;
                    else  $result = 0;
                }
                //return $nombre_ligne_presc_patient."".$operation."".$nombre_ligne_presc_regle."=".$result;    
                break;
            case "état":
                $etat_regle = $elements_regle[5];
                $etat_patient = "";
                if ($patient->sexe == "F") {
                    $etat_patient = $patient->etat;
                }
                if ($etat_patient == $etat_regle) $result = 1;
                else $result = 0;
                break;
            case "Activité":
                $x = 3;
                $travail_regle = "";
                //return '----'.$regle;
                while ($x < count($elements_regle)) {
                    if ($elements_regle[$x] == "ET" || $elements_regle[$x] == "OU") {
                        break;
                    }
                    $travail_regle = $travail_regle . " " . $elements_regle[$x];
                    $x++;
                }

                $travail_patient =  $patient->travaille;

                $travail_regle = str_replace(' ', '', $travail_regle);
                $travail_patient = str_replace(' ', '', $travail_patient);

                if ($travail_regle == $travail_patient) $result = 1;
                else $result = 0;
                break;
            case "Produits":
                $phyto_resultat = DB::select("select produitalimentaires.produit_naturel_fr,frequence,frequence_date from phytotherapies,produitalimentaires where phytotherapies.patient_id=" . $patient->id . " and produitalimentaires.id=phytotherapies.produitalimentaire_id and phytotherapies.date_phyto = '" . $prescription->date_prescription . "'");
                $phyto_prescri[] = "";
                $frequence[] = "";
                $frequence_date[] = "";
                $l = 1;
                $n = 0;
                $et = false;
                foreach ($phyto_resultat as $phy => $phyto_resultat) {
                    $phyto_prescri[$l] = str_replace(' ', '', $phyto_resultat->produit_naturel_fr);
                    $frequence[$n] = $phyto_resultat->frequence;
                    if ($phyto_resultat->frequence_date != null) {
                        $frequence_date[$n] = $phyto_resultat->frequence_date;
                    }
                    $l++;
                    $n++;
                }
                $condition_phyto = "";
                $condition[] = "";
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        if ($elements_regle[$x] == "}") break;
                        $condition_phyto = $condition_phyto . " " . $elements_regle[$x];
                    }
                    if (strchr($condition_phyto, ";")) {
                        $et = true;
                        $phyto_regle = explode(";", trim($condition_phyto, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $phyto_regle = explode("/", trim($condition_phyto, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($phyto_regle); $y++) {
                        if (strchr($phyto_regle[$y], "Occasionnellement")) {
                            $frequence_regle = "Occasionnellement";
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Occasionnellement", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            if ($pos != false) {
                                if ($frequence[$y] == "Occasionnellement") $condition[$y] = 1;
                                else $condition[$y] = 0;
                            }
                        }
                        if (strchr($phyto_regle[$y], "Exceptionnellement")) {
                            $frequence_regle = "Exceptionnellement";
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Exceptionnellement", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            if ($pos != false) {
                                if ($frequence[$y] == "Exceptionnellement") $condition[$y] = 1;
                                else $condition[$y] = 0;
                            }
                        }
                        if (strchr($phyto_regle[$y], "Depuis(jours)")) {
                            $frequence_regle = "Depuis(jours)";
                            // FILTER_SANITIZE_NUMBER_INT pour retourné que la partie nombre
                            $frequence_jours = filter_var($phyto_regle[$y], FILTER_SANITIZE_NUMBER_INT);
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Depuis(jours)", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            $jour_freq = 0;
                            if ($pos != false) {
                                if ($frequence[$y] == "Depuis :") {

                                    $datetime1 = date_create($frequence_date[$y]);
                                    $datetime2 = date_create(date('Y-m-d', strtotime("now")));
                                    $interval = date_diff($datetime1, $datetime2);
                                    $jour_freq = $interval->format('%d');
                                    if ($jour_freq == $frequence_jours) $condition[$y] = 1;
                                    else $condition[$y] = 0;
                                } else $condition[$y] = 0;
                            }
                        }
                    }
                }
                if ($et) {
                    if (count($condition) != count($phyto_regle)) $result = 0;
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
                break;
            case "Médicament":
                //recuperer le nom du medicament ainsi que la dose journaliere dans la prescription
                $medicament_array[] = "";
                $dosage_array[] = "";
                $l = 1;
                foreach ($prescription->lignes as $ligne) {
                    $medicament_resultat = DB::select("select SP_NOM from  sp_specialite where SP_CODE_SQ_PK =" . $ligne->med_sp_id);
                    $dosage_array[$l] = $ligne->dose_mat + $ligne->dose_mid + $ligne->dose_soi + $ligne->dose_ac;
                    $medicament_prescri = "";
                    foreach ($medicament_resultat as $med => $medicament_resultat) {
                        $medicament_prescri = $medicament_resultat->SP_NOM;
                    }
                    $medicament_array[$l] = str_replace(' ', '', $medicament_prescri);
                    $l++;
                }

                //recuperer le nom du medicament ainsi que la dose journaliere dans la regle
                $condition[] = "";
                $condition_med = "";
                $et = false;
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
                // return $med_dos_regle[0]." ".$med_dos_regle[1]." ".$med_dos_regle[2]." ";
                else $med_dos_regle = trim($condition_med, $elements_regle[$x]);
                if (is_array($med_dos_regle) == false) {
                    $med_dos_regle = str_split($med_dos_regle, strlen($med_dos_regle));
                }
                $medicaments_regle[] = "";
                $dosages_regle[] = "";
                for ($x = 0; $x < count($med_dos_regle); $x++) {
                    $med_regle = explode(" ", $med_dos_regle[$x]);
                    $medicament_nom = "";
                    $k = 0;
                    //return $med_dos_regle[0].$med_dos_regle[1].$med_dos_regle[2];
                    while ($med_regle[$k] != "[") {
                        $medicament_nom = $medicament_nom . " " . $med_regle[$k];
                        $k++;
                    }
                    // supprimer les espace de la chaine de caractere pour faciliter la comparaison.
                    $medicaments_regle[$x] = str_replace(' ', '', $medicament_nom);
                    if ($med_regle[$k + 1] != " ")
                        $dosages_regle[$x] = $med_regle[$k + 1];
                    else $dosages_regle = 0;
                }
                for ($y = 0; $y < count($medicaments_regle); $y++) {
                    $pos = array_search($medicaments_regle[$y], $medicament_array);
                    if ($pos != false) {
                        if ($dosages_regle[$y] != 0) {
                            if ($dosages_regle[$y] == $dosage_array[$pos] . "ParJour") {
                                $condition[$y] = 1;
                            } else {
                                $condition[$y] = 0;
                            }
                        } else {
                            $condition[$y] = 1;
                        }
                    }
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
                break;
            default:
                $valeur_examen = "";
                $examen_nom = "";
                $examen_nom_unite = "";
                $v = 0;
                while (substr($elements_regle[$v], 0, 1) != "(") {
                    $examen_nom = $examen_nom . " " . $elements_regle[$v];
                    $v++;
                }

                $examen_nom_unite = $examen_nom . " " . $elements_regle[$v];
                $pos_ex = array_search($examen_nom_unite, $liste_examens);
                if ($pos_ex == false) {
                    for ($y = 0; $y < count($liste_examens); $y++) {
                        $liste_examens[$y] = strtolower($liste_examens[$y]);
                    }
                    $pos_ex = array_search($examen_nom_unite, $liste_examens);
                }
                //supprimer le premier espace ;
                $examen_nom = ltrim($examen_nom, " ");
                $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $examen_nom . "' and unite ='" . trim($elements_regle[$v], "()") . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 1");
                foreach ($examens as $examen => $examens) {
                    $valeur_examen = $examens->valeur;
                }
                if ($valeur_examen != "") {
                    $operation = $elements_regle[$v + 1];
                    $examen_regle = $elements_regle[$v + 2];
                    if ($operation == "=") {
                        if ($examen_regle == $valeur_examen) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "<=") {
                        if ($valeur_examen <= $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == ">=") {
                        if ($valeur_examen >= $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "!=") {
                        if ($valeur_examen != $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == ">") {
                        if ($valeur_examen > $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "<") {
                        if ($valeur_examen < $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "+" || $operation == "-" || $operation == "/" || $operation == "*") {
                        $valeur_examen2 = "";
                        $k = $v + 2;
                        $examen_nom_unite = "";
                        $examen_nom = "";
                        while (substr($elements_regle[$k], 0, 1) != "(") {
                            $examen_nom = $examen_nom . " " . $elements_regle[$k];
                            $k++;
                        }
                        $examen_nom_unite = $examen_nom . " " . $elements_regle[$k];

                        $pos_ex = array_search($examen_nom_unite, $liste_examens);
                        if ($pos_ex == false) {
                            for ($y = 0; $y < count($liste_examens); $y++) {
                                $liste_examens[$y] = strtolower($liste_examens[$y]);
                            }
                            $pos_ex = array_search($examen_nom_unite, $liste_examens);
                        }
                        //supprimer le premier espace ;
                        $examen_nom = ltrim($examen_nom, " ");
                        $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $examen_nom . "' and unite ='" . trim($elements_regle[$k], "()") . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 1");
                        foreach ($examens as $examen => $examens) {
                            $valeur_examen2 = $examens->valeur;
                        }
                        if ($valeur_examen != null && $valeur_examen2 != null) {
                            if ($operation == "+") {
                                $result_opertation = $valeur_examen + $valeur_examen2;
                            } else if ($operation == "-") {
                                $result_opertation = $valeur_examen - $valeur_examen2;
                            } else if ($operation == "/") {
                                $result_opertation = $valeur_examen / $valeur_examen2;
                            } else if ($operation == "*") {
                                $result_opertation = $valeur_examen * $valeur_examen2;
                            }

                            if ($elements_regle[$k + 1] == "=") {
                                if ($elements_regle[$k + 2] == $result_opertation) $result = 1;
                                else  $result = 0;
                            } else if ($elements_regle[$k + 1] == "<=") {
                                if ($result_opertation <= $elements_regle[$k + 2]) $result = 1;
                                else  $result = 0;
                            } else if ($elements_regle[$k + 1] == ">=") {
                                if ($result_opertation >= $elements_regle[$k + 2]) $result = 1;
                                else  $result = 0;
                            } else if ($elements_regle[$k + 1] == "!=") {
                                if ($result_opertation != $elements_regle[$k + 2]) $result = 1;
                                else  $result = 0;
                            } else if ($elements_regle[$k + 1] == ">") {
                                if ($result_opertation > $elements_regle[$k + 2]) $result = 1;
                                else  $result = 0;
                            } else if ($elements_regle[$k + 1] == "<") {
                                if ($result_opertation < $elements_regle[$k + 2]) $result = 1;
                                else  $result = 0;
                            }
                        } else $result = 0;
                        //return $valeur_examen.$operation.$valeur_examen2."=".$result_opertation.$elements_regle[$k+1].$elements_regle[$k+2]."--->".$result;
                    }
                } else $result = 0;
                //return $valeur_examen.$operation.$examen_regle.$result;     
        }
        // les condition pour faire la récursivité de la fonction 
        if ($elements_regle[0] == "Mode" || $elements_regle[0] == "Médicament" || $elements_regle[0] == "Allergie(s)" || $elements_regle[0] == "Pathologie(s)" || $elements_regle[0] == "Produits") {
            $x = 0;
            $p = 0;
            $chaine_a_supp = "";
            $position[] = "";
            $taille_regle = count($elements_regle);
            for ($y = 0; $y < count($liste_examens); $y++) {
                if ($liste_examens[$y] != "Poids(kg)" && strchr($regle, $liste_examens[$y])) {
                    $tab_nom_ex = explode(" ", $liste_examens[$y]);
                    for ($m = 0; $m < count($tab_nom_ex); $m++) {
                        $pos = array_search($tab_nom_ex[$m], $elements_regle);
                        if ($pos != false) {
                            $elements_regle[$pos] = strtolower($elements_regle[$pos]);
                            $position[$p] = $pos;
                            $p++;
                        }
                    }
                }
            }
            for ($x = 0; $x < count($position); $x++) {
                if ($position[$x] != null) {
                    $regle = str_replace(strtoupper($elements_regle[$position[$x]]), $elements_regle[$position[$x]], $regle);
                }
            }
            while ($elements_regle[$x] != "}") {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                $x++;
            }
            if ($x != ($taille_regle - 1)) {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x] . " " . $elements_regle[$x + 1] . " ";
                $regle = strstr($regle, $elements_regle[($x + 1)] . " ");
                $regle = ltrim($regle, $elements_regle[($x + 1)] . " ");
                // return $elements_regle[($x+1)];
                if ($elements_regle[($x + 1)] == "ET") $_SESSION['conditionET']  = 1;
            } else {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                $regle = strstr($regle, $elements_regle[$x] . " ");
                $regle = ltrim($regle, $elements_regle[$x]);
            }
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseInterne($regle, $patient, $prescription);
            }
        } else {

            $chaine_a_supp = "";
            $p = 0;
            $x = 0;
            $position[] = "";
            for ($y = 0; $y < count($liste_examens); $y++) {
                if ($liste_examens[$y] != "Poids(kg)" && strchr($regle, $liste_examens[$y])) {
                    //return "cc".strchr($regle,$liste_examens[$y]);

                    $tab_nom_ex = explode(" ", $liste_examens[$y]);
                    for ($m = 0; $m < count($tab_nom_ex); $m++) {
                        $pos = array_search($tab_nom_ex[$m], $elements_regle);
                        if ($pos != false) {
                            //return $elements_regle[$pos];
                            $elements_regle[$pos] = strtolower($elements_regle[$pos]);
                            //return $elements_regle[$pos];
                            $position[$p] = $pos;
                            $p++;
                        }
                    }
                }
            }

            for ($x = 0; $x < count($position); $x++) {
                if ($position[$x] != null) { //return $elements_regle[$position[$x]];
                    $regle = str_replace(strtoupper($elements_regle[$position[$x]]), $elements_regle[$position[$x]], $regle);
                }
            } //return $regle;
            //if($elements_regle[0]!="Age(ans)")return $regle;

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
            $regle = strstr($regle, $elements_regle[$x] . " ");
            $regle = ltrim($regle, $elements_regle[$x] . " ");
            //if($elements_regle[0]!="Age(ans)")return "--".$regle;
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseInterne($regle, $patient, $prescription);
            }
        }
    }


    //cette fonction c'est le moteur de recherche pour l'editeur de regle de l'analyse de suivie 
    protected function analyseSuivie($regle, $patient, $prescription)
    {
        $liste_examens_req =  DB::select("select element from elements ");
        $elements_regle = explode(" ", $regle);
        $liste_examens[] = "";
        $n = 0;
        foreach ($liste_examens_req as $list => $liste_examens_req) {
            $liste_examens[$n] = $liste_examens_req->element;
            $n++;
        }
        //array_search : c'est une fonction qui retourne la position de l'element trouver sinon elle retourne false
        $pos_ex = array_search($elements_regle[0], $liste_examens);

        if ($pos_ex != false) {
            $elements_regle[0] = "Examens";
        }
        switch ($elements_regle[0]) {
            case "Poids(kg)":
                $poids_result =  DB::select("select element,valeur,date_analyse from bilans,elements where element = 'Poids' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 2");
                $n = 1;
                $valeur[] = "";
                foreach ($poids_result as $poid => $poids_result) {
                    $valeur[$n] = $poids_result->valeur;
                    $n++;
                }
                if ($n > 2) {
                    $poids_patient = $valeur[1];
                } else  $poids_patient = $patient->poids;
                $operation = $elements_regle[1];
                $poids_regle = $elements_regle[2];
                if ($operation == "=") {
                    if ($poids_patient == $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($poids_patient <= $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($poids_patient >= $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($poids_patient != $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($poids_patient > $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($poids_patient < $poids_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "+" || $operation == "-" || $operation == "/" || $operation == "*") {
                    $valeur_examen2 = "";
                    $k = 2; //return $elements_regle[$k];
                    //return $regle;
                    $examen_nom_unite = "";
                    $examen_nom = "";
                    while (substr($elements_regle[$k], 0, 1) != "(") {
                        $examen_nom = $examen_nom . " " . $elements_regle[$k];
                        $k++;
                    }
                    $examen_nom_unite = $examen_nom . " " . $elements_regle[$k];
                    // echo $examen_nom_unite;
                    //return $examen_nom_unite;
                    $pos_ex = array_search($examen_nom_unite, $liste_examens);
                    if ($pos_ex == false) {
                        for ($y = 0; $y < count($liste_examens); $y++) {
                            $liste_examens[$y] = strtolower($liste_examens[$y]);
                        }
                        $pos_ex = array_search($examen_nom_unite, $liste_examens);
                    }
                    //return "--".$regle;
                    //supprimer le premier espace ;
                    $examen_nom = ltrim($examen_nom, " ");
                    // return "--".$examen_nom."--".trim($elements_regle[$v],"()");
                    $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $examen_nom . "' and unite ='" . trim($elements_regle[$k], "()") . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 1");
                    foreach ($examens as $examen => $examens) {
                        $valeur_examen2 = $examens->valeur;
                    }
                    // return $valeur_examen2;
                    if ($valeur_examen != null && $valeur_examen2 != null) {
                        if ($operation == "+") {
                            // return $valeur_examen."((".$valeur_examen2;
                            $result_opertation = $valeur_examen + $valeur_examen2;
                        } else if ($operation == "-") {
                            $result_opertation = $valeur_examen - $valeur_examen2;
                        } else if ($operation == "/") {
                            $result_opertation = $valeur_examen / $valeur_examen2;
                        } else if ($operation == "*") {
                            $result_opertation = $valeur_examen * $valeur_examen2;
                        }

                        if ($elements_regle[$k + 1] == "=") {
                            if ($elements_regle[$k + 2] == $result_opertation) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "<=") {
                            if ($result_opertation <= $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == ">=") {
                            if ($result_opertation >= $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "!=") {
                            if ($result_opertation != $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == ">") {
                            if ($result_opertation > $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        } else if ($elements_regle[$k + 1] == "<") {
                            if ($result_opertation < $elements_regle[$k + 2]) $result = 1;
                            else  $result = 0;
                        }
                    } else $result = 0;
                    //return $valeur_examen.$operation.$valeur_examen2."=".$result_opertation.$elements_regle[$k+1].$elements_regle[$k+2]."--->".$result;
                }

                break;
            case "Pathologie(s)":
                $pathologies_patient[] = "";
                $n = 1;
                $pathologies =  DB::select("select distinct pathologie from  pathologies,pathologie_patient where pathologies.id = pathologie_patient.pathologie_id and patient_id=" . $patient->id);
                foreach ($pathologies as $pat => $pathologies) {
                    $pathologies_patient[$n] = $pathologies->pathologie;
                    $n++;
                }
                $et = false;
                $condition_pathologie = "";
                $pathologies_regle[] = "";
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        $condition_pathologie = $condition_pathologie . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                    if (strchr($condition_pathologie, ";")) {
                        $et = true;
                        $pathologies_regle = explode(";", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $pathologies_regle = explode("/", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($pathologies_regle); $y++) {
                        $pathologies_regle[$y] = str_replace(' ', '', $pathologies_regle[$y]);
                        $pos = array_search($pathologies_regle[$y], $pathologies_patient);
                        if ($pos != false) {
                            $condition[$y] = 1;
                        } else $condition[$y] = 0;
                    }
                } else {
                    $pathologies_regle = $elements_regle[3];
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
                break;
            case "Allergie(s)":
                $allegries_patient[] = "";
                $n = 1;
                $allegries =  DB::select("select distinct allergie from  allergies,allergie_patient where allergies.id = allergie_patient.allergie_id and patient_id=" . $patient->id);
                foreach ($allegries as $alr => $allegries) {
                    $allegries_patient[$n] = str_replace(' ', '', $allegries->allergie);
                    $n++;
                }
                $condition_allergie = "";
                $allegries_regle[] = "";
                $et = false;
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        $condition_allergie = $condition_allergie . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                    if (strchr($condition_allergie, ";")) {
                        $et = true;
                        $allegries_regle = explode(";", trim($condition_allergie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $allegries_regle = explode("/", trim($condition_allergie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($allegries_regle); $y++) {
                        $allegries_regle[$y] = str_replace(' ', '', $allegries_regle[$y]);
                        $pos = array_search($allegries_regle[$y], $allegries_patient);
                        if ($pos != false) {
                            $condition[$y] = 1;
                        } else $condition[$y] = 0;
                    }
                } else {
                    $allegries_regle = $elements_regle[3];
                    $pos = array_search($allegries_regle, $allegries_patient);
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
                break;
            case "Examens":
                if (strchr($regle, "hausse") || strchr($regle, "baisse")) {
                    $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $liste_examens[$pos_ex] . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 2");
                    $n = 1;
                    $valeur[] = "";
                    foreach ($examens as $examen => $examens) {
                        $examen_patient = $examens->element;
                        $valeur[$n] = $examens->valeur;
                        $n++;
                    }
                    if ($n >= 2) {
                        if ($elements_regle[3] == "hausse") {
                            if ($valeur[1] > $valeur[2]) $result = 1;
                            else $result = 0;
                        } else {
                            if ($valeur[1] < $valeur[2]) $result = 1;
                            else $result = 0;
                        }
                    } else $result = 0;
                } else {
                    $valeur_examen = "";
                    $examens =  DB::select("select element,valeur,date_analyse from bilans,elements where element ='" . $liste_examens[$pos_ex] . "' and bilans.element_id = elements.id and bilans.patient_id=" . $patient->id . " ORDER BY bilans.date_analyse DESC LIMIT 1");
                    foreach ($examens as $examen => $examens) {
                        $valeur_examen = $examens->valeur;
                    }
                    $operation = $elements_regle[1];
                    $examen_regle = $elements_regle[2];
                    if ($operation == "=") {
                        if ($examen_regle == $valeur_examen) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "<=") {
                        if ($valeur_examen <= $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == ">=") {
                        if ($valeur_examen >= $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "!=") {
                        if ($valeur_examen != $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == ">") {
                        if ($valeur_examen > $examen_regle) $result = 1;
                        else  $result = 0;
                    } else if ($operation == "<") {
                        if ($valeur_examen < $examen_regle) $result = 1;
                        else  $result = 0;
                    }
                }
                break;
            case "Service":
                $operation = $elements_regle[1];
                $x = 2;
                $service_regle = "";
                while ($elements_regle[$x] != "ET" || $elements_regle[$x] != "OU" || $x != (count($elements_regle) - 1)) {
                    $service_regle = $service_regle . $elements_regle[$x];
                    $x++;
                }
                $service_patient =  $patient->service;
                $service_regle = str_replace(' ', '', $service_regle);
                $service_patient = str_replace(' ', '', $service_patient);
                if ($service_patient == $service_regle) $result = 1;
                else $result = 0;
                break;
            case "Durée":
                $operation = $elements_regle[2];
                $dureeHos_regle = $elements_regle[3];
                $dureeHos_patient = "";

                $hospitalisations =  DB::select("select date_admission,date_sortie from  hospitalisations where patient_id =" . $patient->id);
                foreach ($hospitalisations as $hosp => $hospitalisations) {
                    $debut = date_create($hospitalisations->date_admission);
                    $fin = date_create($hospitalisations->date_sortie);
                    $date_interval = date_diff($fin, $debut);
                    $dureeHos_patient = $date_interval->format('%d');
                }
                if ($operation == "=") {
                    if ($dureeHos_patient == $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<=") {
                    if ($dureeHos_patient <= $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">=") {
                    if ($dureeHos_patient >= $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "!=") {
                    if ($dureeHos_patient != $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == ">") {
                    if ($dureeHos_patient > $dureeHos_regle) $result = 1;
                    else  $result = 0;
                } else if ($operation == "<") {
                    if ($dureeHos_patient < $dureeHos_regle) $result = 1;
                    else  $result = 0;
                }
                break;
            case "Produits":
                $phyto_resultat = DB::select("select produitalimentaires.produit_naturel_fr,frequence,frequence_date from phytotherapies,produitalimentaires where phytotherapies.patient_id=" . $patient->id . " and produitalimentaires.id=phytotherapies.produitalimentaire_id and phytotherapies.date_phyto = '" . $prescription->date_prescription . "'");
                $phyto_prescri[] = "";
                $frequence[] = "";
                $frequence_date[] = "";
                $l = 1;
                $n = 0;
                $et = false;
                foreach ($phyto_resultat as $phy => $phyto_resultat) {
                    $phyto_prescri[$l] = str_replace(' ', '', $phyto_resultat->produit_naturel_fr);
                    $frequence[$n] = $phyto_resultat->frequence;
                    if ($phyto_resultat->frequence_date != null) {
                        $frequence_date[$n] = $phyto_resultat->frequence_date;
                    }
                    $l++;
                    $n++;
                }
                $condition_phyto = "";
                $condition[] = "";
                if ($elements_regle[3] == "{") {
                    for ($x = 4; $x < count($elements_regle); $x++) {
                        if ($elements_regle[$x] == "}") break;
                        $condition_phyto = $condition_phyto . " " . $elements_regle[$x];
                    }
                    if (strchr($condition_phyto, ";")) {
                        $et = true;
                        $phyto_regle = explode(";", trim($condition_phyto, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    } else
                        $phyto_regle = explode("/", trim($condition_phyto, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
                    for ($y = 0; $y < count($phyto_regle); $y++) {
                        if (strchr($phyto_regle[$y], "Occasionnellement")) {
                            $frequence_regle = "Occasionnellement";
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Occasionnellement", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            if ($pos != false) {
                                if ($frequence[$y] == "Occasionnellement") $condition[$y] = 1;
                                else $condition[$y] = 0;
                            }
                        }
                        if (strchr($phyto_regle[$y], "Exceptionnellement")) {
                            $frequence_regle = "Exceptionnellement";
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Exceptionnellement", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            if ($pos != false) {
                                if ($frequence[$y] == "Exceptionnellement") $condition[$y] = 1;
                                else $condition[$y] = 0;
                            }
                        }
                        if (strchr($phyto_regle[$y], "Depuis(jours)")) {
                            $frequence_regle = "Depuis(jours)";
                            $frequence_jours = filter_var($phyto_regle[$y], FILTER_SANITIZE_NUMBER_INT);
                            $phyto_regle[$y] = strstr($phyto_regle[$y], "Depuis(jours)", 1);
                            $phyto_regle[$y] = str_replace(' ', '', $phyto_regle[$y]);
                            $pos = array_search($phyto_regle[$y], $phyto_prescri);
                            $jour_freq = 0;
                            if ($pos != false) {
                                if ($frequence[$y] == "Depuis :") {
                                    $datetime1 = date_create($frequence_date[$y]);
                                    $datetime2 = date_create(date('Y-m-d', strtotime("now")));
                                    $interval = date_diff($datetime1, $datetime2);
                                    $jour_freq = $interval->format('%d');
                                    if ($jour_freq == $frequence_jours) $condition[$y] = 1;
                                    else $condition[$y] = 0;
                                } else $condition[$y] = 0;
                            }
                        }
                    }
                }
                if ($et) {
                    if (count($condition) != count($phyto_regle)) $result = 0;
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
                break;
            case "Médicament":
                //recuperer le nom du medicament ainsi que la dose journaliere dans la prescription
                $medicament_array[] = "";
                $dosage_array[] = "";
                $l = 1;
                foreach ($prescription->lignes as $ligne) {
                    $medicament_resultat = DB::select("select SP_NOM from  sp_specialite where SP_CODE_SQ_PK =" . $ligne->med_sp_id);
                    $dosage_array[$l] = $ligne->dose_mat + $ligne->dose_mid + $ligne->dose_soi + $ligne->dose_ac;
                    $medicament_prescri = "";
                    foreach ($medicament_resultat as $med => $medicament_resultat) {
                        $medicament_prescri = $medicament_resultat->SP_NOM;
                    }
                    $medicament_array[$l] = str_replace(' ', '', $medicament_prescri);
                    $l++;
                }

                //recuperer le nom du medicament ainsi que la dose journaliere dans la regle
                $condition[] = "";
                $condition_med = "";
                $et = false;
                if ($elements_regle[2] == "{") {
                    for ($x = 3; $x < count($elements_regle); $x++) {
                        $condition_med = $condition_med . " " . $elements_regle[$x];
                        if ($elements_regle[$x] == "}") break;
                    }
                }
                if (strchr($condition_med, ";")) {
                    $et = true;
                    $med_dos_regle = explode(";", trim($condition_med, $elements_regle[$x]));
                } else if (strchr($condition_med, "/"))
                    $med_dos_regle = explode("/", trim($condition_med, $elements_regle[$x]));
                else $med_dos_regle = trim($condition_med, $elements_regle[$x]);
                if (is_array($med_dos_regle) == false) {
                    $med_dos_regle = str_split($med_dos_regle, strlen($med_dos_regle));
                }
                $medicaments_regle[] = "";
                $dosages_regle[] = "";
                for ($x = 0; $x < count($med_dos_regle); $x++) {
                    $med_regle = explode(" ", $med_dos_regle[$x]);
                    $medicament_nom = "";
                    $k = 0;
                    while ($med_regle[$k] != "[") {
                        $medicament_nom = $medicament_nom . " " . $med_regle[$k];
                        $k++;
                    }
                    // supprimer les espace de la chaine de caractere pour faciliter la comparaison.
                    $medicaments_regle[$x] = str_replace(' ', '', $medicament_nom);
                    if ($med_regle[$k + 1] != " ")
                        $dosages_regle[$x] = $med_regle[$k + 1];
                    else $dosages_regle = 0;
                }
                for ($y = 0; $y < count($medicaments_regle); $y++) {
                    $pos = array_search($medicaments_regle[$y], $medicament_array);
                    if ($pos != false) {
                        if ($dosages_regle[$y] != 0) {
                            if ($dosages_regle[$y] == $dosage_array[$pos] . "ParJour") {
                                $condition[$y] = 1;
                            } else {
                                $condition[$y] = 0;
                            }
                        } else {
                            $condition[$y] = 1;
                        }
                    }
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
                break;
        }
        if ($elements_regle[0] == "Médicament" || $elements_regle[0] == "Allergie(s)" || $elements_regle[0] == "Pathologie(s)" || $elements_regle[0] == "Produits") {
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
                if ($elements_regle[($x + 1)] == "ET") $_SESSION['conditionET']  = 1;
            } else {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                $regle = strstr($regle, $elements_regle[$x] . " ");
                $regle = ltrim($regle, $elements_regle[$x]);
            }
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseSuivie($regle, $patient, $prescription);
            }
        } else {
            if ($elements_regle[0] == "Examens") {
                $elements_regle[0] = $liste_examens[$pos_ex];
            }
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
            $regle = strstr($regle, $elements_regle[$x] . " ");
            $regle = ltrim($regle, $elements_regle[$x]) . " ";
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseSuivie($regle, $patient, $prescription);
            }
        }
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    protected function analyseTherapeutique($regle, $patient, $prescription, $eduTest)
    {
        $elements_regle = explode(" ", $regle);
        $result = "";
        //les variables qui stoque les infos du patient / ou du test
        $pathologies_patient[] = "";
        $n = 1;
        $medicament_array[] = "";
        $l = 1;
        $observation_patient = "";

        $pathologies =  DB::select("select distinct pathologie from pathologies,pathologie_patient where pathologies.id = pathologie_patient.pathologie_id and patient_id=" . $patient->id);
        foreach ($pathologies as $pat => $pathologies) {
            $pathologies_patient[$n] = $pathologies->pathologie;
            $n++;
        }
        //recuperer le nom du medicament ainsi que la dose journaliere dans la prescription

        foreach ($prescription->lignes as $ligne) {
            $medicament_resultat = DB::select("select SP_NOM from  sp_specialite where SP_CODE_SQ_PK =" . $ligne->med_sp_id);
            $medicament_prescri = "";
            foreach ($medicament_resultat as $med => $medicament_resultat) {
                $medicament_prescri = $medicament_resultat->SP_NOM;
            }
            $medicament_array[$l] = str_replace(' ', '', $medicament_prescri);
            $l++;
        }

        $bilans = Patient::with('questionnaires')->find($patient->id);

        // $bilans = DB::table('questionnaires')
        //         ->select(DB::raw('SUM(reponse) as reponse'),'date_questionnaire','question_id','user_id','users.name','users.prenom')
        //         ->join('users','users.id','questionnaires.user_id')
        //         ->where ('patient_id',$patient->id)
        //         ->groupBy('date_questionnaire','patient_id')
        //         ->get();
        foreach ($bilans->questionnaires as $bilan) {
            if ($bilan->pivot->reponse == "1" || $bilan->pivot->reponse == "2") $observation_patient = "modérément observant";
            else if ($bilan->pivot->reponse == "3" || $bilan->pivot->reponse == "4") $observation_patient = "non observant";
            else $observation_patient = "très observant";
        }

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
                    if (strchr($condition_pathologie, ";")) {
                        $et = true;
                        $pathologies_regle = explode(";", trim($condition_pathologie, $elements_regle[$x])); //la fonction trim c'est pour supprimer une patie de la chaine de caractere  
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
                // return "pat".$result."*****".$regle;
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
                    $med_dos_regle = explode(";", trim($condition_med, $elements_regle[$x]));
                } else if (strchr($condition_med, "/"))
                    $med_dos_regle = explode("/", trim($condition_med, $elements_regle[$x]));
                else $med_dos_regle = trim($condition_med, $elements_regle[$x]);
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
                //return "meed".$result."**".$regle;
                break;
            default:

                if ($observation_patient == null) {
                    $result = 0;
                } else if (strchr($regle, $observation_patient)) $result = 1;
                else $result = 0;
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
                if ($elements_regle[($x + 1)] == "ET") $_SESSION['conditionET']  = 1;
            } else {
                $chaine_a_supp = $chaine_a_supp . " " . $elements_regle[$x];
                $regle = strstr($regle, $elements_regle[$x]);
                $regle = ltrim($regle, $elements_regle[$x]);
            }
            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseTherapeutique($regle, $patient, $prescription, $eduTest);
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
            $regle = strstr($regle, $elements_regle[$x] . " ");
            $regle = ltrim($regle, $elements_regle[$x] . " ");

            if ($regle == "") {
                return $result;
            } else {
                return $result . " " . $this->analyseTherapeutique($regle, $patient, $prescription, $eduTest);
            }
        }
    }
}
