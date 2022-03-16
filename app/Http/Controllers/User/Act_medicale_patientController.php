<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\act_medicale_patient;
use DB;

class Act_medicale_patientController extends Controller
{
    public function store(Request $request)
    {
           $act = new act_medicale_patient;
           $act->consultation_id=$request->cons_id;
           $act->patient_id=$request->patient_id;
           $act->act_medicale_id=$request->actm;
           $act->description=$request->description;
           $act->date_act=$request->date_act;
           $act->save();
        return redirect()->back()->with(['message' , 'Act Medicale ajouté avec succés !', 'tab' => 'tab_12']);
    }
    public function destory($id){
        act_medicale_patient::where('id',$id)->delete();

        //redirect ot show page with success
        return redirect()->back()->with(['message' , 'Act medicale est supprimé avec succés !', 'tab' => 'tab_12']);

    }
    public function getAct($id)
    {

        $ho =act_medicale_patient::find($id);

        return response()->json( [
                    $ho
                ]);
    }
    public function update(Request $request, $id)
    {
        $act = act_medicale_patient::find($id);
        $act->consultation_id=$request->cons_id;
        $act->patient_id=$request->patient_id;
        $act->act_medicale_id=$request->actm;
        $act->description=$request->description;
        $act->date_act=$request->date_act;
        $act->save();
        return redirect()->back()->with(['message' , 'Act medicale modifie avec succés !', 'tab' => 'tab_12']);

    }    
    public function getAll()
    {
        $elements = act_medicale::all();

        return response()->json( [
            $elements
         ]);
    }
    public function shows($patient_id , $id  )
    {
        $consultation = DB::table('act_medicale_patients')
                            ->join('patients','patients.id','act_medicale_patients.patient_id')
                            ->join('act_medicales','act_medicales.id','act_medicale_patients.act_medicale_id')
                            ->where('act_medicale_patients.patient_id', $patient_id)
                            ->where('act_medicale_patients.id', $id)
                            ->select('patients.nom as n','patients.prenom as pp' ,'patients.date_naissance','act_medicale_patients.*','act_medicales.nom','patients.*')
                            ->get();
        return view('user.print.print_act',compact('consultation'));
    }

  
}
