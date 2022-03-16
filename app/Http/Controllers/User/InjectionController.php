<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\Patient;
use Auth;

class InjectionController extends Controller
{
    // GET ALL PRESCRIPTIONS TO INJECT TO THE PATIENT
    public function index()
    {
        if (Auth::user()->cant('prescriptions.inject')) return redirect()->back();
        $result = $this->getAdministrations();

        // $result = Patient::with(['hospi' => function ($query) {
        //     $query->whereService(Auth::user()->service);
        // }])->get();
        // $history = Auth::user()->with([
        //     'injections.line.prescription.prescripteur',
        //     'injections.line.prescription.patient',
        // ])->get();
        // return $history;
        return view('user.administration.show', compact('result'));
    }

    public function showArchives()
    {
        if (Auth::user()->cant('prescriptions.inject')) return redirect()->back();
        $result = $this->getAdministrations();
        return view('user.administration.archive', compact('result'));
    }

    public function getAdministrations()
    {
        $result = Prescription::with(['prescripteur', 'patient.hospi' => function ($query) {
            $query->whereService(Auth::user()->service);
        }, 'lignes'])
            ->whereNotIn('etats', ['Exam done', 'Exam in progress'])
            ->orderBy('date_prescription', 'desc')
            ->get();
        return $result;
    }
    // GET ALL INJECTIONS DONE BY THE AUTH USER

    // UPDATE INJECTION

    // STOP INJECTION OF DRUG

    // GET ALL INJECTIONS OF SPECIFIC PRESCRIPTION
}
