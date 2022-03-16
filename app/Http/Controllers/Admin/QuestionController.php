<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Http\Requests\StoreQuestion;
use DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.questionnaire.show', ['questions' => Questionnaire::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestion $request)
    {
        $questionaire = new Questionnaire;
        $questionaire->type = $request->type;
        $questionaire->save();

        foreach ($request->questions as $ques) {
            $question = new Question;
            $question->question = $ques;
            $question->questionnaire_id = $questionaire->id;
            $question->save();
        }

        return redirect(route('questionnaires.index'))->with('message', 'Questionnaire créer avec succées !');
    }

    /**
     * Display history of observance.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Show all questionnaires realisez bu the auth pharmacist

        $questionnaires = DB::table('questionnaires')
            ->join('patient_questionnaire', 'patient_questionnaire.questionnaire_id', 'questionnaires.id')
            ->join('patients', 'patients.id', 'patient_questionnaire.patient_id')
            ->select(DB::raw('SUM(patient_questionnaire.reponse) as reponse'), 'patient_questionnaire.date_questionnaire', 'patients.nom', 'patients.prenom', 'questionnaires.type')
            ->where('user_id', $id)
            ->groupBy('date_questionnaire', 'patient_id')
            ->get();

        return view('user.pharmacien.observance.observ_history', compact('questionnaires'));
        //return response()->json($questionnaires);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.questionnaire.edit', ['questionnaire' => Questionnaire::findOrFail($id)]);
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
        $questionnaire = Questionnaire::find($id);

        $questionnaire->type = $request->type;
        $questionnaire->save();

        $questionnaire->questions()->delete(); //Supprimer les questions associé au questionnaire

        foreach ($request->questions as $ques) {
            $question = new Question;
            $question->question = $ques;
            $question->questionnaire_id = $questionnaire->id;
            $question->save();
        }

        return redirect(route('questionnaires.index'))->with('message', 'Questionnaire modifier avec succées !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Questionnaire::find($id)->delete();

        return redirect()->back()->with('message', 'Questionnaire supprimer avec succés !');
    }

    /**
     * return questions from questionnaire_id   
     *
     * @return void
     * @author 
     **/
    public function getQuestions($questionnaireId)
    {
        return Question::where('questionnaire_id', $questionnaireId)->get();
    }
}
