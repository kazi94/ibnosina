<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;
use DB;
use Auth;

class ConsultationController extends Controller
{

    public function store(Request $request)
    {


        if (Auth::user()->cant('consultations.create'))
            return redirect()->back()->with('message', 'Action non autorisée !');
        \LogActivity::addToLog('Consultation créer');

        $this->storePatient($request);

        $consultation = $this->storeConsultation($request);
        // broadcast(new \App\Events\PrescriptionAnalyse("analyse_ph", $consultation->id, $consultation->created_by))->toOthers();

        return redirect()->back()->with(['message' => 'Consultation ajouté avec succés !', 'tab' => 'tab_10']);
    }

    private function storePatient($attr)
    {
        $patient = Patient::find($attr->patient_id);
        if (isset($attr->pathologies)) {

            foreach ($attr->pathologies as $path) {
                //collect all inserted record IDs
                $path_id_array[$path] = ['type' => 'path'];
            }
            //associate patient with pathologies
            $patient->pathologies()->detach();
            $patient->pathologies()->sync($path_id_array);
        } else {
            $patient->pathologies()->detach();
        }
        if (!empty($attr->famille_antecedants)) {
            # code...
            foreach ($attr->famille_antecedants as $ant) {
                //collect all inserted record IDs
                $ant_id_array[$ant] = ['type' => 'ant'];
            }
            // sync with pathologies
            $patient->antecedentsFamilliaux()->detach($ant_id_array);
            $patient->antecedentsFamilliaux()->attach($ant_id_array);
        }
        $patient->allergies()->sync($attr->allergies);
        $patient->operations()->sync($attr->operations);

        return $patient;
    }
    /**
     * Sync Patient with antecedent in patient_pathologie table
     *
     * @param Patient $patient
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function syncAntecedents($patient, $antecedents)
    {
        foreach ($antecedents as $ant) {
            //collect all inserted record IDs
            $ant_id_array[$ant] = ['type' => 'ant'];
            // sync with pathologies
        }
        $patient->antecedentsFamilliaux()->sync($ant_id_array, false);
    }


    /**
     * Sync Pathologies with Patient 
     *
     * @param Patient $patient
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function syncPathologies($patient, $pathologies)
    {
        foreach ($pathologies as $path) {
            //collect all inserted record IDs
            $path_id_array[$path] = ['type' => 'path'];
        }
        $patient->pathologies()->sync($path_id_array);
    }
    public function storeConsultation($data)
    {
        $consultation = new Consultation;
        $consultation->patient_id        = $data->patient_id;
        $consultation->motif             = $data->motif;
        // $consultation->signe             = isset($data->signe) ? implode(',', $data->signe) : '';
        $consultation->debut_symptome    = $data->debut_symptome;
        $consultation->examen            = $data->examen;
        $consultation->compte_rendu      = $data->compte_rendu;
        $consultation->orientation       = $data->orientation;
        $consultation->certificat        = $data->certificat;
        $consultation->date_consultation = $data->date_rapport;
        $consultation->created_by        = Auth::user()->id;
        $consultation->save();
        $consultation->signes()->sync($data->signe);
        return $consultation->id;
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
        if (Auth::user()->cant('consultations.update'))
            return redirect()->back()->with('message', 'Action non autorisée !');
        \LogActivity::addToLog('Consultation modifié');
        $this->updateConsultation($request, $id);

        return redirect()->back()->with(['message' => 'Consultation modifié avec succés !', 'tab' => 'tab_10']);
    }

    public function updateConsultation($data, $id)
    {
        $consultation = Consultation::find($id);
        $consultation->motif             = $data->motif;
        //$consultation->signe             = isset($data->signe) ? implode(',', $data->signe) : '';
        $consultation->debut_symptome    = $data->debut_symptome;
        $consultation->examen            = $data->examen;
        $consultation->compte_rendu      = $data->compte_rendu;
        $consultation->orientation       = $data->orientation;
        $consultation->certificat        = $data->certificat;
        // $consultation->date_consultation = $data->date_rapport;
        $consultation->updated_at        = date('Y-m-d H:i:s');
        $consultation->updated_by        = $data->user()->id;
        $consultation->save();
        $consultation->signes()->sync($data->signe);
        return $consultation;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public function destroys($id, $patient_id)
    {
        if (Auth::user()->cant('consultations.delete'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        // $bilan = DB::table('bilans')
        //     ->where('patient_id', $patient_id)
        //     ->where('consultation_id', $id)
        //     ->select('bilans.*')
        //     ->get();
        // $act = DB::table('act_medicale_patients')
        //     ->where('patient_id', $patient_id)
        //     ->where('consultation_id', $id)
        //     ->select('act_medicale_patients.*')
        //     ->get();
        // $prescription = DB::table('prescriptions')
        //     ->where('patient_id', $patient_id)
        //     ->where('consultation_id', $id)
        //     ->select('prescriptions.*')
        //     ->get();
        // if (count($bilan) > 0 || count($act) > 0 || count($prescription) > 0) {

        //     return redirect()->back()->with('message', 'Action non autorisée
        //          vous avez ' . count($bilan) . ' bilan, ' . count($act) . ' act medicale, ' . count($prescription) . ' prescription a supprimer
        //          avant la suppresion de la consulation ');
        // } else {
        //fetch row to delete
        Consultation::where([
            'id'         => $id,
            'patient_id' => $patient_id
        ])->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE consultations AUTO_INCREMENT = 1;");
        return redirect()->back()->with('message', 'Consultation supprimé avec succés');
        // }
        // if (Auth::user()->cant('consultations.delete'))
        //     return redirect()->back()->with('message', 'Action non autorisée !');

        // $deleted = Consultation::where('id', $id)->delete();

        //return $deleted ?  response()->json(['response' => 'success', 'msg' => 'Consultation supprimé avec succés !'], 200) : 'Erreur dans la suppression';
    }
}
