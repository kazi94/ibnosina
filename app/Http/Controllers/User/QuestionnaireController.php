<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use DB;
class QuestionnaireController extends Controller
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
        $j=0;
        for ($i=0; $i < count($request->questions); $i++) { 
            $oui ="oui".($i+1);
            if ($request->$oui!="on") $j++;
        }
        DB::table('patient_questionnaire')->insert([
            'questionnaire_id'  => $request->questionnaire_id, 
            'user_id'           => $request->user()->id,
            'patient_id'        => $request->patient_id,
            'date_questionnaire'=> (isset($request->date_qs)) ? $request->date_qs : now(),
            'reponse'           => $j

        ]);        
        return redirect()->back()->with(['message' => 'Questionnaire ajouté avec succés !', 'tab' => 'tab_8']);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // //Show all questionnaires realisez bu the auth pharmacist
        $questionnaires = DB::table('questionnaires')
                    ->join('patient_questionnaire' , 'patient_questionnaire.questionnaire_id' , 'questionnaires.id')
                    ->join('patients' , 'patients.id' , 'patient_questionnaire.patient_id')
                    ->select(DB::raw('SUM(patient_questionnaire.reponse) as reponse'),'patient_questionnaire.date_questionnaire','patients.nom' , 'patients.prenom', 'questionnaires.type')
                    ->where ('user_id',$id)
                    ->groupBy('date_questionnaire','patient_id')
                    ->get();
        
         return view('user.pharmacien.observance.observ_history' , compact('questionnaires'));

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroys($id , $patient_id , $user_id , $date_questionnaire)
    {
        
        $deleted = DB::table('patient_questionnaire')->where([
            'patient_id'         => $patient_id,
            'date_questionnaire' => $date_questionnaire
        ])->delete();

        return $deleted ?  response()->json(['response' => 'success' , 'msg' => 'Observance supprimé avec succés !'] , 200) : 'Erreur dans la suppression';
    }
}
