<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Storage;
use DB;
use PDF;

class HospitalisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitalisationn = Hospitalisation::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitalisationn = Hospitalisation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->cant('hospitalisations.create'))
            return redirect()->back();

        $messages = [
            'required'  => "Le champs :attribute est obligatoire",
            'numeric'   => "Le champs :attribute doit ètre numérique",
            'after' => " Le champs :attribute doit etre apres date admission",
        ];
        if ($request->date_sortie != "") {
            $validator = Validator::make($request->all(), [
                'date_sortie'        => 'after:date_admission',

            ], $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $hospitalisation = $this->storeHospitalisation($request);
        return redirect()->back()->with(['message' => 'Hospitalisation ajoutée avec succés !', 'tab' => 'tab_11']);
    }
    /**
     * Undocumented function
     *
     * @param [type] $data
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function storeHospitalisation($data)
    {
        $ho = new Hospitalisation;
        $ho->hopital        = "CHU Tlemcen";
        $ho->service        = $data->service;
        $ho->num_biais      = $data->numbiais;
        $ho->chambre        = $data->chambre;
        $ho->owned_by        = $data->owned_by;
        $ho->lit            = $data->lit;
        $ho->motifs         = $data->motif;
        $ho->patient_id     = $data->patient_id;
        $ho->date_admission = $data->date_admission;
        $ho->date_sortie    = $data->date_sortie;
        $ho->motif_sortie   = $data->motif_sortie;
        $ho->service_transfert = $data->service_transfert;
        $ho->save();

        $this->handleCauseOfExit($data);

        return $ho->id;
    }

    /**
     * Gestion du motifs de sortie du patient
     * de son décé et sa sortie de l'hopital
     *  décédé will be archived and readonly
     * out of hospital just archived
     * @param $data Description
     * @return type
     * @throws conditon
     **/
    protected function handleCauseOfExit($data = null)
    {
        if ($data->motif_sortie == "décés" || $data->motif_sortie == "hopital") {
            $patient = \App\Models\Patient::find($data->patient_id);
            $patient->archived = true;
            if ($data->motif_sortie == "décés") {
                $patient->readonly = true;
            }
            $patient->save();
        }
    }

    protected function store_auto(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hospitalisation)
    {
        $ho = Hospitalisation::find($hospitalisation);
        $messages = [
            'required'  => "Le champs :attribute est obligatoire",
            'numeric'   => "Le champs :attribute doit ètre numérique",
            'after' => " Le champs :attribute doit etre apres date admission",
        ];

        $validator = Validator::make($request->all(), [
            // "name"    => "required|array|min:3", //"Name" must be an array with at least 3 elements.
            'date_sortie'        => 'nullable|date|date_format:Y-m-d|after:date_admission',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $ho->service           = $request->service;
        $ho->num_biais         = $request->numbiais;
        $ho->chambre           = $request->chambre;
        $ho->lit               = $request->lit;
        $ho->motifs            = $request->motif;
        $ho->owned_by          = $request->owned_by;
        $ho->patient_id        = $request->patient_id;
        $ho->date_admission    = $request->date_admission;
        $ho->date_sortie       = $request->date_sortie;
        $ho->motif_sortie      = $request->motif_sortie;
        $ho->service_transfert = $request->service_transfert;
        $ho->save();

        $this->handleCauseOfExit($request);
        return redirect()->back()->with(['message' => 'Hospitalisation modifie avec succés !', 'tab' => 'tab_11']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('hospitalisations.delete'))
            return redirect()->back()->with('message', 'Action non autorise !');;
        //fetch row to delete
        Hospitalisation::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE hospitalisations AUTO_INCREMENT = 1;");
        return redirect()->back()->with('message', 'Hospitalisation supprime avec succés !');
    }

    private function getMedicaments($id)
    {


        $resul_trait = $resul_pres = $resul_auto = $lignes = array();

        // $patient = Patient::with('prescriptions.lignes','traitements.lignes','autos.lignes')->find($id);

        //resortir les prescriptions
        $pres = DB::select("
                select  LEFT(t3.catc_code_pk,1) as first, 
                        users.prenom as user_prenom ,users.name as user_name ,
                        users.hopital,users.service ,
                        patients.nom,patients.prenom,patients.date_naissance,patients.id as patient_id,
                        t1.*,
                        h.date_admission,h.date_sortie
                from 
                    users , patients, hospitalisations as h ,
                    prescriptions as t0,ligneprescriptions as t1,
                    sp_specialite t2 , catc_classeatc t3
                where
                    users.id           = patients.owned_by
                and patients.id        = t0.patient_id
                and patients.id        = h.patient_id
                and t0.id              = t1.prescription_id
                and t1.med_sp_id       = t2.sp_code_sq_pk
                and t2.sp_catc_code_fk = t3.catc_code_pk
                and t0.date_prescription in (
                    select max(created_at) 
                                from prescriptions 
                                    where patient_id = ?            
                                     and (etats ='prescription' 
                                            or etats = 'invalide')
                        )
                
                and patients.id = ?           
                and h.date_admission IN (
                    SELECT MAX(date_admission)
                        FROM `hospitalisations`
                             WHERE `patient_id` = ?
                                 GROUP BY `patient_id`)
                ", [$id, $id, $id]);

        foreach ($pres as $val) {
            $res  = DB::select('select * from catc_classeatc where catc_code_pk = ? ', [$val->first]);
            $resul_pres[] = array_merge((array) $val, (array)$res[0]);
        }

        $auto = DB::select(
            "
                select  LEFT(t3.catc_code_pk,1) as first, 
                        users.prenom as user_prenom ,users.name as user_name ,
                        users.hopital,users.service ,
                        patients.nom,patients.prenom,patients.date_naissance,patients.id as patient_id,
                        t1.*,
                        h.date_admission,h.date_sortie
                from 
                    users ,hospitalisations as h, patients, automedications as t0,
                    ligneprescriptions as t1,
                    sp_specialite t2 ,catc_classeatc t3
                where 
                    users.id               = patients.owned_by
                    and patients.id        = t0.patient_id
                    and patients.id        = h.patient_id
                    and t0.id              = t1.automedication_id
                    and t1.med_sp_id       = t2.sp_code_sq_pk
                    and t2.sp_catc_code_fk = t3.catc_code_pk
                    and t0.patient_id      = ?            
                    and h.date_admission IN (
                        SELECT MAX(date_admission)
                            FROM `hospitalisations`
                                WHERE `patient_id` =?
                                    GROUP BY `patient_id`
                                )
                                                 and t1.date_etats in( SELECT distinct(max(date_etats))
                                FROM `ligneprescriptions`  
                                group by med_sp_id) ",
            [$id, $id]
        );
        foreach ($auto as $val) {
            $res  = DB::select('select * from catc_classeatc where catc_code_pk = ? ', [$val->first]);
            $resul_auto[] = array_merge((array) $val, (array)$res[0]);
        }
        //resortir les traitement médicamenteux   
        $trait = DB::select(
            "
                select  LEFT(t3.catc_code_pk,1) as first, 
                        users.prenom as user_prenom ,users.name as user_name ,users.hopital,users.service ,
                        patients.nom,patients.prenom,patients.date_naissance,patients.id as patient_id,
                        t1.*,
                        h.date_admission,h.date_sortie
                from 
                    users , patients,hospitalisations as h, 
                    traitementchroniques as t0,ligneprescriptions as t1,
                    sp_specialite t2 , catc_classeatc t3
                where 
                    users.id = patients.owned_by
                    and patients.id = t0.patient_id
                    and patients.id = h.patient_id
                    and t0.id = t1.traitementchronique_id
                    and t1.med_sp_id = t2.sp_code_sq_pk
                    and t2.sp_catc_code_fk = t3.catc_code_pk
                    and t1.etats = 'En cours'
                    and t0.patient_id = ?
                    and h.date_admission IN (
                        SELECT MAX(date_admission)
                            FROM `hospitalisations`
                                WHERE `patient_id` =?
                                    GROUP BY `patient_id`)
                                                     and t1.date_etats in( SELECT distinct(max(date_etats))
                                FROM `ligneprescriptions`  
                                group by med_sp_id) ",
            [$id, $id]
        );

        foreach ($trait as $val) {
            $res  = DB::select('select * from catc_classeatc where catc_code_pk = ? ', [$val->first]);
            $resul_trait[] = array_merge((array) $val, (array)$res[0]);
        }

        $lignes = array_merge($resul_trait, $resul_pres, $resul_auto);

        usort($lignes, function ($item1, $item2) { // cette fonction permet de trier les table associatiove par clé choisi dans item
            return $item1['CATC_NOMF'] <=> $item2['CATC_NOMF'];
        });
        return $lignes;
    }

    // public function showsho($patient_id)
    // {
    //     $hospitalisation = DB::table('hospitalisations')
    //         ->join('patients', 'patients.id', 'hospitalisations.patient_id')
    //         ->join('users', 'users.id', 'patients.created_by')
    //         ->where('hospitalisations.patient_id', $patient_id)->select('patients.*', 'hospitalisations.*', 'users.name', 'users.prenom AS pre')->get();

    //     $patient = \App\Models\Patient::find($patient_id);
    //     $lignes = $this->getMedicaments($patient_id);

    //     return view('user.print.report-patient', compact('hospitalisation', 'lignes', 'patient'));
    // }

    /**
     * Print the Report Folder of Patient 
     *
     * @param Request $request
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function printReport(Request $request)
    {
        $data = $request->all();
        $dateD = $request->dateD;
        $dateF = $request->dateF;
        $id = $request->patient_id;
        if ($dateD && $dateF) {
            $patient =  $this->getReportTwoDates($dateD, $dateF, $id);
        } else if ($dateD) {
            $patient =  $this->getReportDateD($dateD, $id);
        } else if ($dateF) {
            $patient =  $this->getReportDateF($dateF, $id);
        } else {
            $patient =  $this->getAllReport($id);
        }
        return view('user.print.report-patient', compact('data', 'patient'));
    }

    private function getReportTwoDates($dateD, $dateF, $id)
    {
        return Patient::with([
            'antecedentsFamilliaux',
            'medecinTraitant',
            'operations',
            'radiosDesc',
            'communes',
            'pathologies',
            'allergies',
            'actDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween('date_act', [$dateD, $dateF]);
            },
            'actDesc.acts',
            'hospiDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween('date_admission', [$dateD, $dateF]);
            },
            'bilansDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween('date_analyse', [$dateD, $dateF]);
            },
            'consultationsDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween('date_consultation', [$dateD, $dateF]);
            },
            'consultationsDesc.signes',
            'prescriptionsDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween('date_prescription', [$dateD, $dateF]);
            },
            'prescriptionsDesc.lignes',
            'traitementsDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween(DB::raw("cast(traitementchroniques.created_at as date)"), [$dateD, $dateF]);
            },
            'traitementsDesc.lignes',
            'autosDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween(DB::raw("cast(automedications.created_at as date)"), [$dateD, $dateF]);
            },
            'autosDesc.lignes',
            'phytosDesc' => function ($q) use ($dateD, $dateF) {
                return $q->whereBetween(DB::raw("cast(created_at as date)"), [$dateD, $dateF]);
            },
            'lastEducations'
        ])->find($id);
    }
    private function getReportDateD($dateD, $id)
    {
        return Patient::with([
            'antecedentsFamilliaux',
            'medecinTraitant',
            'operations',
            'radiosDesc',
            'communes',
            'pathologies',
            'allergies',
            'actDesc' => function ($q) use ($dateD) {
                return $q->where('date_act', '>=', $dateD);
            },
            'actDesc.acts',
            'hospiDesc' => function ($q) use ($dateD) {
                return $q->where('date_admission', '>=', $dateD);
            },
            'bilansDesc' => function ($q) use ($dateD) {
                return $q->where('date_analyse', '>=', $dateD);
            },
            'consultationsDesc' => function ($q) use ($dateD) {
                return $q->where('date_consultation', '>=', $dateD);
            },
            'consultationsDesc.signes',
            'prescriptionsDesc' => function ($q) use ($dateD) {
                return $q->where('date_prescription', '>=', $dateD);
            },
            'prescriptionsDesc.lignes',
            'traitementsDesc' => function ($q) use ($dateD) {
                return $q->where(DB::raw("cast(traitementchroniques.created_at as date)"), '>=', $dateD);
            },
            'traitementsDesc.lignes',
            'autosDesc' => function ($q) use ($dateD) {
                return $q->where(DB::raw("cast(automedications.created_at as date)"), '>=', $dateD);
            },
            'autosDesc.lignes',
            'phytosDesc' => function ($q) use ($dateD) {
                return $q->where(DB::raw("cast(created_at as date)"), '>=', $dateD);
            },
            'lastEducations'
        ])->find($id);
    }
    private function getReportDateF($dateF, $id)
    {
        return Patient::with([
            'antecedentsFamilliaux',
            'medecinTraitant',
            'operations',
            'radiosDesc',
            'communes',
            'pathologies',
            'allergies',
            'actDesc' => function ($q) use ($dateF) {
                return $q->where('date_act', '<=', $dateF);
            },
            'actDesc.acts',
            'hospiDesc' => function ($q) use ($dateF) {
                return $q->where('date_admission', '<=', $dateF);
            },
            'bilansDesc' => function ($q) use ($dateF) {
                return $q->where('date_analyse', '<=', $dateF);
            },
            'consultationsDesc' => function ($q) use ($dateF) {
                return $q->where('date_consultation', '<=', $dateF);
            },
            'consultationsDesc.signes',
            'prescriptionsDesc' => function ($q) use ($dateF) {
                return $q->where('date_prescription', '<=', $dateF);
            },
            'prescriptionsDesc.lignes',
            'traitementsDesc' => function ($q) use ($dateF) {
                return $q->where(DB::raw("cast(traitementchroniques.created_at as date)"), '<=', $dateF);
            },
            'traitementsDesc.lignes',
            'autosDesc' => function ($q) use ($dateF) {
                return $q->where(DB::raw("cast(automedications.created_at as date)"), '<=', $dateF);
            },
            'autosDesc.lignes',
            'phytosDesc' => function ($q) use ($dateF) {
                return $q->where(DB::raw("cast(created_at as date)"), '<=', $dateF);
            },
            'lastEducations'
        ])->find($id);
    }
    private function getAllReport($id)
    {
        return Patient::with([
            'antecedentsFamilliaux',
            'medecinTraitant',
            'operations',
            'radiosDesc',
            'communes',
            'pathologies',
            'allergies',
            'actDesc',
            'hospiDesc',
            'bilansDesc',
            'consultationsDesc.signes',
            'prescriptionsDesc.lignes',
            'traitementsDesc.lignes',
            'autosDesc.lignes',
            'phytosDesc',
            'lastEducations'
        ])->find($id);
    }
    public function getHospitalisation($id)
    {

        $ho = Hospitalisation::find($id);

        return response()->json([
            $ho
        ]);
    }
}
