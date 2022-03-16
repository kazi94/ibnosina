<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Auth;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function showInterventions()
    {
        $user = Auth::user();
        return view('user.pharmacien.intervention.history', compact('user'));
    }

    /**
     * Liste des Prescriptions à risque pour analyse et intervention
     *
     * 
     **/
    public function showRisquePrescriptions()
    {
        $patients = Patient::with('prescriptionsRisquePharma')->get();
        // $patients = Patient::with('prescriptionsRisquePharma', 'prescriptionsInvalide')->get();
        return view('user.pharmacien.intervention.show', compact('patients'));
    }
}
