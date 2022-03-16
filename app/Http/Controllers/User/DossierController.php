<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Grossesse;
use App\Models\Operation_chirugicale;
use App\Http\Requests\StorePatient;
use App\Repositories\User\Patients;
use App\Repositories\UtilityRepository;
use DB;

class DossierController extends Controller
{

    private $utilityRepository;

    public function __construct(UtilityRepository $utilityRepository)
    {
        $this->utilityRepository = $utilityRepository;
    }
    public function createPatient($type, $id = null)
    {

        if (Auth::user()->cant('patients.create')) return redirect()->back();
        //get the patient
        $patient = \App\Models\Patient::find($id);
        //delete patient
        \App\Models\Patient::destroy($id);
        DB::update("ALTER TABLE patients AUTO_INCREMENT = 1;");

        $pathologies = $this->utilityRepository->getPathologies();
        $allergies   = $this->utilityRepository->getAllergies();
        $operations = $this->utilityRepository->getOperations();
        $grossesses = $this->utilityRepository->getGrossesse();
        $wilayas = $this->utilityRepository->getWilayas();
        $dairasTlemcen = $this->utilityRepository->getDairasTlemcen();

        if ($type == 'normal')
            // redirect to normal creation of patient
            return redirect()->route('patient.create.zero.step');

        if ($type == 'consultation') {
            session(['type' => 'consultation']);
        } else session(['type' => 'hospitalisation']);

        return view('user.patient.create_rapide.step_one', compact('patient', 'pathologies', 'allergies', 'operations', 'grossesses', 'wilayas', 'dairasTlemcen'));
    }

    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postcreatePatient(StorePatient $request, Patients $patients)
    {
        $pat_control = new \App\Repositories\User\Patients(new \App\Models\Patient, new \App\Services\PhotoService);
        $patient = $pat_control->create($request);
        $request->session()->put('patient_id', $patient->id);
        return redirect()->route('patient.create.step.two');
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createConsultation($id = null)
    {
        // Get Consultation by ID
        $consultation = \App\Models\Consultation::find($id);
        // Destroy Consultation
        \App\Models\Consultation::destroy($id);
        DB::update("ALTER TABLE consultations AUTO_INCREMENT = 1;");
        return view('user.patient.create_rapide.step_two')->with('consultation', $consultation);
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreateConsultation(Request $request)
    {

        $cons_control = new \App\Http\Controllers\User\ConsultationController;
        $consultation_id = $cons_control->storeConsultation($request);
        $request->session()->put('consultation_id', $consultation_id);

        if (session()->has('type') && session('type') == 'consultation') {
            // if is consultation, redirect to prescription step
            return redirect()->route('patient.create.step.four');
        }
        return redirect()->route('patient.create.step.three');
        // return view('user.patient.create_rapide.step_three', compact('consultation_id'));
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHospitalisation($id = null)
    {
        // Get Hospitalisation by ID
        $hospitalisation = \App\Models\Hospitalisation::find($id);
        // Destroy \App\Models\Hospitalisation
        \App\Models\Hospitalisation::destroy($id);
        DB::update("ALTER TABLE hospitalisations AUTO_INCREMENT = 1;");

        return view('user.patient.create_rapide.step_three')->with('hosp', $hospitalisation);
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreateHospitalisation(Request $request)
    {
        $cons_control = new \App\Http\Controllers\User\HospitalisationController;
        $hospi_id = $cons_control->storeHospitalisation($request);
        $request->session()->put('hospi_id', $hospi_id);
        return redirect()->route('patient.create.step.four');


        // return view('user.patient.create_rapide.step_four', compact('hospi_id'));
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPrescription($id = null)
    {
        // Get Prescription from ID
        $presc = \App\Models\Prescription::with('lignes')->find($id);
        // Delete Prescription
        \App\Models\Prescription::destroy($id);
        DB::update("ALTER TABLE prescriptions AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");

        return view('user.patient.create_rapide.step_four')->with('presc', $presc);
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreatePrescription(Request $request)
    {
        $presc_control = new \App\Http\Controllers\User\PrescriptionController;
        $presc_id = $presc_control->storePrescription($request);
        $request->session()->put('presc_id', $presc_id);

        return response([], 200);
        //return redirect()->route('patient.create.step.five');
        // return view('user.patient.create_rapide.step_four', compact('presc_id'));
    }
    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTraitement($ids = null)
    {
        // Get Prescription from ID
        // $trait = \App\Models\Traitementchronique::with('lignes')->find($ids);
        // Delete Prescription
        \App\Models\Traitementchronique::destroy($ids);
        DB::update("ALTER TABLE traitementchroniques AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");

        return view('user.patient.create_rapide.step_five');
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreateTraitement(Request $request)
    {

        $trait_control = new \App\Http\Controllers\User\TraitementchroniqueController;
        $trait_ids = $trait_control->storeTraitement($request);
        $trait_ids;
        session()->forget('trait_ids');
        $trait_ids = implode(',', $trait_ids);
        $request->session()->put('trait_ids', $trait_ids);
        // return redirect()->route('patient.create.step.six');
        $url = "/patient/consultation-rapide/etape-six/";
        return response()->json($url, 200);
    }
    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBilan($id = null)
    {
        // Get Prescription from ID
        //$trait = \App\Models\Prescription::with('lignes')->find($id);
        // Delete Prescription
        \App\Models\Prescription::destroy($id);
        DB::update("ALTER TABLE prescriptions AUTO_INCREMENT = 1;");
        DB::update("ALTER TABLE bilans AUTO_INCREMENT = 1;");

        $bilans = DB::table('elements')->select('bilan')->distinct()->get();
        return view('user.patient.create_rapide.step_six', compact('bilans'));
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreateBilan(Request $request)
    {
        if (
            ($request->type == 'bilan' && isset($request->checkedElements) && array_sum($request->checkedElements) != 0)
            || $request->type == 'radio'
        ) {

            $bilan_control = new \App\Http\Controllers\User\BilanController;
            $bilan_id = $bilan_control->storeBilan($request);
            $request->session()->put('bilan_id', $bilan_id);
        }
        return redirect()->route('patient.create.step.final');
        // return view('user.patient.create_rapide.step_final', compact('bilan_id'));
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function createReport($id = null)
    {

        return view('user.patient.create_rapide.step_final');
        // return view('user.patient.create_rapide.step_final', compact('bilans'));
    }

    /**
     * Show the step One Form for creating a new Prescription.
     *
     * @return \Illuminate\Http\Response
     */
    public function postcreateReport(Request $request, $id = null)
    {
        $cons_control = new \App\Repositories\User\Consultations(new \App\Models\Consultation);

        $cons_control->updateRapport($request, $id);
        session()->forget(['patient_id', 'consultation_id', 'presc_id', 'traits_ids', 'bilan_id', 'hospi_id']);
        return redirect()->route('patient.edit', ['id' => $request->patient_id]);
    }
}
