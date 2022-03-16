<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegleSuivPatient;

use DB;


class RegleSuivPatientController extends Controller
{
    
    public function vu($patient_id,$regle_id)
    {
       /* $regle_suiv_patient = RegleSuivPatient::where(['patient_id' => $patient_id,'regle_id' => $regle_id])->first();
        $regle_suiv_patient->etat = "Vu";
        $regle_suiv_patient->save();*/
        DB::update('update regle_suiv_patients set etat = "Vu" where patient_id = ? and regle_id = ?', [$patient_id,$regle_id]);
        return redirect()->back();
    }

}




