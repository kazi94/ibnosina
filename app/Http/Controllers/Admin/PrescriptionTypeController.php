<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PrescriptionType;
use DB;

class PrescriptionTypeController extends Controller
{
    /**
     * Show Prescriptions type
     *
     * @return View
     **/
    public function index()
    {
        // get list of prescriptions type : service && examen
        $prescriptionsServices = PrescriptionType::whereType('service')->get();
        $prescriptionsExamens = PrescriptionType::whereType('examen')->get();
        $bilans = DB::table('elements')->select('bilan')->distinct()->get();
        // return to view
        return view('admin.prescription-type.show', compact('prescriptionsServices', 'prescriptionsExamens', 'bilans'));
    }
}
