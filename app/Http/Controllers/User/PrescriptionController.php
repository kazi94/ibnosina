<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared;
use App\Http\Requests\StorePrescription;
use App\Models\Prescription;
use App\Models\Ligneprescription;
use App\Repositories\User\Interfaces\PrescriptionRepositoryInterface;
use DB;
use Validator;
use Auth;
use DateTime;
use Debugbar;

class PrescriptionController extends Controller
{
    private $prescriptionRepo;

    public function __construct(PrescriptionRepositoryInterface $prescriptionRepo)
    {
        $this->prescriptionRepo = $prescriptionRepo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrescription $request)
    {
        if (Auth::user()->cant('prescriptions.create'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        $lines = json_decode($request->med_sp_id, true);

        $lines = collect($lines)->map(function ($line) {
            $line['nbr_jours'] = $this->getDays($line['type_j'], $line['nbr_jours']);
            $line['dose'] = $this->calculateTotal($line);
            return $line;
        });
        $request['lines'] = $lines->toArray();

        $prescription = $this->prescriptionRepo->create($request);

        session(['tab' => 'tab_2']);
        //return redirect(route('patient.edit',$request->patient_id))->with('message' , 'Prescription ajoutée avec succés !');
        return response()->json("success", 201);
    }
    private function calculateTotal($data)
    {
        $doseTotal = 0;

        if (isset($data['med_sp_id'])) { // si medic not null et exist
            $doseTotal =
                ($data['dose_matin'] ? (float)$data['dose_mat'] : 0)  +
                ($data['dose_midi'] ? (float)$data['dose_mid'] : 0)  +
                ($data['dose_soir'] ? (float)$data['dose_soi'] : 0)  +
                ($data['dose_avant_coucher'] ? (float)$data['dose_ac'] : 0);
        }

        return $doseTotal;
    }
    public function storePrescription($data)
    {
        $id = DB::table('prescriptions')->insertGetId( // Insert prescription
            [
                'patient_id'        => $data->patient_id,
                'consultation_id' => $data->cons_id,
                'created_by' => $data->user()->id,
                'last_presc_id'     => $data->last_presc_id,
                'etats' => 'prescription',
                'date_prescription' => $data->date_prescription
            ]
        );
        $meds = json_decode($data->med_sp_id, true);

        for ($i = 0; $i < count($meds); $i++) { //Enregistrement des lignes de la prescription

            $nbr_jour = $this->getDays($meds[$i]['type_j'], $meds[$i]['nbr_jours']);

            if (isset($meds[$i]['med_sp_id'])) { // si medic not null et exist
                $doseTotal =
                    ($meds[$i]['dose_matin'] ? (float)$meds[$i]['dose_mat'] : 0)  +
                    ($meds[$i]['dose_midi'] ? (float)$meds[$i]['dose_mid'] : 0)  +
                    ($meds[$i]['dose_soir'] ? (float)$meds[$i]['dose_soi'] : 0)  +
                    ($meds[$i]['dose_avant_coucher'] ? (float)$meds[$i]['dose_ac'] : 0);
                $ligne = $this->storeNewLine($meds[$i], $nbr_jour, $doseTotal, $id);
            }
        } //END LOOP    

        return $id;
    }

    private function getDays($type, $days)
    {
        if ($type == "mois")  $nbr_jour = 28 * $days;
        else if ($type == "semaines")  $nbr_jour = 7 * $days;
        else $nbr_jour = $days;
        return $nbr_jour;
    }



    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function edit($id)
    {
        $prescription = Prescription::with('lignes.medicament')->find($id);
        $prescription->lignes->map(function ($e) {
            $e->medicament_dci = $e->medicament->SP_NOM;
            return $e;
        });
        return response()->json($prescription, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prescription  = Prescription::with('lignes.medicament', 'intervention.lignesIP')->find($id);
        $prescription->lignes = $prescription->lignes->map(function ($e) {
            $e->medicament_dci = $e->medicament->SP_NOM;
            return $e;
        });



        return $prescription;
        $lignes    = $prescription->lignes;
        $ips       = $prescription->intervention->lignesIP;
    }


    public function fetchInjectionsHistory($id)
    {
        $result = Ligneprescription::with(
            [
                'injections:id,prise,injected_at,line_id,injected_by',
                'injections.administrator' => function ($query) {
                    $query->select(['id', DB::raw("concat('Dr.',name,prenom) as nurse")]);
                },
                'injections.line:id,med_sp_id',
                'injections.line.medicament' => function ($query) {

                    $query->select(['SP_CODE_SQ_PK', 'SP_NOM']);
                }
            ]
        )
            ->where('prescription_id', $id)
            // ->where('stopped', '!=', 1)
            ->get();
        $injections = array();
        foreach ($result as $child) {
            $injections = array_merge($injections, $child->injections->toArray());
        }

        return response()->json([
            'data' => $injections
        ], 200);
    }
    /**
     * Print Prescription
     *
     * @return Prescription
     * @author _KaziWhite**__SALAF4_WebDev**
     **/
    public function shows($patient_id, $id)
    {
        $prescription = DB::table('prescriptions')
            //->join('ligneprescriptions','prescriptions.id','ligneprescriptions.prescription_id')
            ->join('patients', 'patients.id', 'prescriptions.patient_id')
            ->join('hospitalisations', 'patients.id', 'hospitalisations.patient_id')
            ->join('users', 'users.id', 'prescriptions.created_by')
            ->where('prescriptions.patient_id', $patient_id)
            ->where('prescriptions.id', $id)
            ->select('patients.nom as p_nom', 'patients.prenom as p_prenom', 'patients.date_naissance as p_dn', 'patients.num_tel_1 as p_num1', 'patients.adresse as add', 'patients.poids', 'patients.ville', 'hospitalisations.*', 'prescriptions.id as p_id', 'prescriptions.*', 'users.*')
            ->get();
        // dd($prescription);
        return view('user.patient.print.print_prescription', ['prescription' => $prescription]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ids_to_update = [];
        $lines = json_decode($request->med_sp_id, true);

        $prescription = Prescription::findOrFail($id);
        $prescription->updated_by = Auth::user()->id;
        $prescription->save();

        // delete all lignes prescription
        // $prescription->lignes()->delete();


        // get IDS Of Prescription
        $ids = $prescription->number_of_lines()->toArray();  // [{ id : 1} , {id : 2}, ...]
        foreach ($ids as $id) {
            $tmp[] = $id['id'];
        }

        foreach ($lines as $line) {
            try {
                // Check if is new line or exesitng line
                if (isset($line['id']) && !empty($line['id'])) {
                    // Update Line Prescription
                    $nbr_jour = $this->getDays($line['type_j'], $line['nbr_jours']);
                    $doseTotal = (float)
                    ($line['dose_matin'] ? (float)$line['dose_mat'] : 0)  +
                        ($line['dose_midi'] ? (float)$line['dose_mid'] : 0)  +
                        ($line['dose_soir'] ? (float)$line['dose_soi'] : 0)  +
                        ($line['dose_avant_coucher'] ? (float)$line['dose_ac'] : 0);

                    $ligne = Ligneprescription::find($line['id']);
                    $ligne->dose_matin         = $line['dose_matin'];
                    $ligne->dose_mat           = $line['dose_mat'];
                    $ligne->dose_midi          = $line['dose_midi'];
                    $ligne->dose_mid           = $line['dose_mid'];
                    $ligne->dose_soir          = $line['dose_soir'];
                    $ligne->dose_soi           = $line['dose_soi'];
                    $ligne->dose_avant_coucher = $line['dose_avant_coucher'];
                    $ligne->dose_ac            = $line['dose_ac'];
                    $ligne->type_j             = $line['type_j'];
                    $ligne->nbr_jours          = $nbr_jour;
                    $ligne->dose               = $doseTotal;
                    $ligne->save();

                    $ids_to_update[] = $ligne->id;
                } else {
                    // Create new Line Prescription
                    $nbr_jour = $this->getDays($line['type_j'], $line['nbr_jours']);
                    $doseTotal = (float)
                    ($line['dose_matin'] ? (float)$line['dose_mat'] : 0)  +
                        ($line['dose_midi'] ? (float)$line['dose_mid'] : 0)  +
                        ($line['dose_soir'] ? (float)$line['dose_soi'] : 0)  +
                        ($line['dose_avant_coucher'] ? (float)$line['dose_ac'] : 0);

                    $ligne = $this->storeNewLine($line, $nbr_jour, $doseTotal, $prescription->id);
                }
            } catch (\Throwable $th) {
                return response($th->getMessage(), 400);
            }
        }


        // order the two arrays
        sort($tmp);
        sort($ids_to_update);
        // get the ids non exist in the post request
        $ids_to_delete = array_diff_assoc($tmp, $ids_to_update);

        if (count($ids_to_delete)) {
            Ligneprescription::destroy($ids_to_delete);
            DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
            DB::update("ALTER TABLE injections AUTO_INCREMENT = 1;");
        }


        return response()->json(null, 204);
    }


    private function storeNewLine($line, $nbr_jour, $doseTotal, $id)
    {
        $ligne = new Ligneprescription;
        $ligne->dose_matin         = $line['dose_matin'];
        $ligne->dose_mat           = $line['dose_mat'];
        $ligne->dose_midi          = $line['dose_midi'];
        $ligne->dose_mid           = $line['dose_mid'];
        $ligne->dose_soir          = $line['dose_soir'];
        $ligne->dose_soi           = $line['dose_soi'];
        $ligne->dose_avant_coucher = $line['dose_avant_coucher'];
        $ligne->dose_ac            = $line['dose_ac'];
        $ligne->type_j             = $line['type_j'];
        $ligne->nbr_jours          = $nbr_jour;
        $ligne->dose               = $doseTotal;
        $ligne->unite              = $line['unite'];
        $ligne->voie               = $line['voie'];
        $ligne->prescription_id    = $id;
        $ligne->med_sp_id          = $line['med_sp_id'];
        $ligne->save();

        return $ligne;
    }
    public function faireEducation($id)
    {
        $prescription  = Prescription::find($id);
        // if($prescription == null){return view('user.patient.create');}else{
        $prescription->etatAnalyseTherap = "faite";
        $prescription->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('prescriptions.delete'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        $deleted = Prescription::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE prescriptions AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE injections AUTO_INCREMENT = 1;");
        return $deleted ?  response()->json(['response' => 'success', 'msg' => 'Prescription supprimé avec succés !'], 200) : 'Erreur dans la suppression';
    }

    public function destroyPrescriptionExamen($id)
    {
        $deleted = Prescription::where('id', $id)->delete();
        DB::update("ALTER TABLE prescriptions AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");

        return redirect()->back()->with('message', 'Demande d\'examen annulée avec succés');
    }
    /**
     * update injected value of ligne prescription
     *
     *
     * @param  $line_id 
     * @param  $isChecked value of injected 0 or 1
     * @return message
     **/
    public function updateInjectedValue($line_id, $isChecked)
    {
        // update the injected value
        $line = Ligneprescription::find($line_id);
        $line->injected = $isChecked;
        $line->injected_by = Auth::user()->id;
        $line->save();

        return response()->json("Médicament Administrer au patient", 201);
    }
}
