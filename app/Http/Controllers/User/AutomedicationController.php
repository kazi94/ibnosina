<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Ligneprescription;
use App\Models\Automedication;
use App\Rules\validateMedic;
use DB;
use Validator;
use Auth;

class AutomedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->cant('automedications.create')) {
            return redirect()->back();
        }
        $id = array();
        $tmp = null;
        $messages = [
            'required' => "Le champs :attribute est obligatoire",
            'numeric'  => "Le nombre de jours doit ètre numérique",
            'unique'   => "Le médicament est dèja renseigné !",
            'min'      => "Le champs :attribute doit ètre infèrieur à 0",
        ];


        $validator = Validator::make(
            $request->all(),
            [
                'date_etats.*'          => 'required|date_format:Y-m-d|before:tomorrow',
                //'med_sp_id.*'           => 'required|string',
                'dose_matin.*'         => 'nullable|numeric|min:0',
                'dose_midi.*'           => 'nullable|numeric|min:0',
                'dose_soir.*'           => 'nullable|numeric|min:0',
                'dose_avant_coucher.*'  => 'nullable|numeric|min:0',
                'med_sp_id.*'           => new validateMedic($request->patient_id, 'a')
            ],
            $messages
        );

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if ($request->user()->id != '1' && $request->user()->role->analyse_ph == "on")  // soit 'on' ou 'null'
            $tmp = 1;
        $meds = json_decode($request->med_sp_id, true);
        for ($i = 0; $i < count($meds); $i++) {

            $id[$i] = DB::table('automedications')->insertGetId(
                [
                    'patient_id' => $request->patient_id,
                    'created_by' => $request->user()->id,
                    'created_at' => gmDate('Y-m-d H:i:s'),
                ]
            );

            $ligne = new Ligneprescription;
            $ligne->medecin_externe = $request->medecin_externe;
            $ligne->etats = "En cours";
            $ligne->date_etats = $meds[$i]['date_etats'];
            $ligne->status_hopital = $meds[$i]['status_hopital'];
            $ligne->dose = $meds[$i]['dose'];
            $ligne->dose_matin = $meds[$i]['dose_matin'];
            // $ligne->repas_matin = $meds[$i]['repas_matin'];
            $ligne->dose_midi = $meds[$i]['dose_midi'];
            // $ligne->repas_midi = $meds[$i]['repas_midi'];
            $ligne->dose_soir = $meds[$i]['dose_soir'];
            // $ligne->repas_soir = $meds[$i]['repas_soir'];
            // $ligne->tmp = $tmp;
            $ligne->dose_avant_coucher = $meds[$i]['dose_avant_coucher'];
            $ligne->unite = $meds[$i]['unite'];
            $ligne->voie = ((isset($meds[$i]['voie'])) ? $meds[$i]['voie'] : "");

            // if ($request->type_j == "mois")  $nbr_jour = 31*$request->nbr_jours[$i];
            //   else if ($request->type_j == "semaines")  $nbr_jour = 7*$request->nbr_jours[$i];
            //     else $nbr_jour = $request->nbr_jours[$i];

            // $ligne->nbr_jours = $nbr_jour;
            $ligne->automedication_id = $id[$i];
            $ligne->med_sp_id = $meds[$i]['med_sp_id'];
            $ligne->save();

            // $val = $request->medicament_dci_id[$i];
            // $result = explode(',',$val);
            // for ($j=0; $j < count($result); $j++)  
            //   $ligne->medicaments()->attach($result[$j]);
        }
        session(['tab' => 'tab_5']);
        return response()->json("success", 201);

        //   return redirect()->back()->with(['message' => 'Médicament(s) ajouté(s) avec succés !', 'tab' => 'tab_5']);      
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
        //
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
        if (Auth::user()->cant('automedications.update'))
            return redirect()->back();

        // $this->validate($request, [
        //     'date_etats'  => 'required|date|before:tomorrow|after:' . $request->old_date,
        // ]);

        // $traitement             = Automedication::find($id);
        // $traitement->updated_by = $request->user()->id;
        // $traitement->updated_at = now();
        // $traitement->save();

        $ligne                  = Ligneprescription::find($id);
        $ligne->medecin_externe = $request->medecin_externe;
        $ligne->date_etats      = $request->date_etats;
        $ligne->status_hopital  = $request->status_hopital;
        $ligne->dose_matin      = $request->dose_matin;
        $ligne->repas_matin     = $request->repas_matin;
        $ligne->dose_midi       = $request->dose_midi;
        $ligne->repas_midi      = $request->repas_midi;
        $ligne->dose_soir       = $request->dose_soir;
        $ligne->repas_soir      = $request->repas_soir;
        $ligne->dose_avant_coucher = $request->dose_avant_coucher;
        $ligne->save();

        return redirect()->back()->with(['message' => 'Médicament modifié!', 'tab' => 'tab_5']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fetch row to delete
        if (Auth::user()->cant('automedications.delete'))
            return redirect()->back();

        $deleted = Automedication::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE automedications AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
        return $deleted ?  response()->json(['response' => 'success', 'msg' => 'Médicament supprimé avec succés !'], 200) : 'Erreur dans la suppression';
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function destroy_tmp($id)
    {
        //fetch row to delete
        $deleted = Ligneprescription::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
        return response()->json(['response' => 'success', 'msg' => 'Médicament supprimé avec succés !'], 200);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function confirm($id)
    {
        //fetch row to delete
        $ligne = Ligneprescription::find($id);
        $ligne->tmp = NULL;
        $ligne->save();

        return response()->json(['response' => 'success', 'msg' => 'Médicament Validé avec succés !'], 200);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function getHisAutomedication()
    {

        $line = Ligneprescription::find($_POST['ligne_id']);

        return response()->json($line, 201);
    }

    /**
     * return the last state of the automedication
     *
     *
     * @param Type $id 
     * @return LignePrescription
     **/
    public function getLastState($id)
    {

        $line = Ligneprescription::find($id);

        $automedication_id = $line->automedication_id;

        $history = Ligneprescription::where('automedication_id', $automedication_id)->get();

        return response()->json([
            'line' => $line,
            'history' => $history
        ], 200);
    }

    /**
     * udpate state
     * @param Request  $var Description
     **/
    public function updateState(Request $req, $id)
    {
        // $this->validate($request, [
        //   'date_etats'  => 'required|date|before:tomorrow|after:' . $request->old_date,
        // ]);
        $ligne = Ligneprescription::find($id);

        $newLine = new LignePrescription;
        $newLine->date_etats = $req->date_etats;
        $newLine->etats = $req->etats;
        $newLine->medecin_externe         = $ligne->medecin_externe;
        $newLine->status_hopital          = $ligne->status_hopital;
        $newLine->dose_matin              = $ligne->dose_matin;
        $newLine->dose              = $ligne->dose;
        $newLine->repas_matin             = $ligne->repas_matin;
        $newLine->dose_midi               = $ligne->dose_midi;
        $newLine->repas_midi              = $ligne->repas_midi;
        $newLine->dose_soir               = $ligne->dose_soir;
        $newLine->repas_soir              = $ligne->repas_soir;
        $newLine->dose_avant_coucher      = $ligne->dose_avant_coucher;
        $newLine->automedication_id      = $ligne->automedication_id;
        $newLine->unite = $ligne->unite;
        $newLine->voie = $ligne->voie;
        $newLine->med_sp_id = $ligne->med_sp_id;
        $newLine->save();
        // $traitement = Traitementchronique::find($ligne->traitementchronique_id);
        // $traitement->updated_by = $request->user()->id;
        // $traitement->updated_at = now();
        // $traitement->save();    

        return redirect()->back()->with(['message' => 'Mise à jour effectuée!', 'tab' => 'tab_5']);
    }
}
