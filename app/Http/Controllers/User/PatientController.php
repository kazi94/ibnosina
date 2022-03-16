<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatient;
use App\Models\Patient;
use Auth;
use Illuminate\Support\Facades\DB;
use Image;
// use App\ModelsChimio\Traitement;
// use App\ModelsChimio\Cure;
// use App\ModelsChimio\FormuleSC;
use App\Repositories\User\Interfaces\PatientRepositoryInterface;
use App\Repositories\UtilityRepository;

class PatientController extends Controller
{
    /**
     * Utilities Repositorie
     *
     * @var [type]
     */
    private $utilityRepository;
    /**
     * Patient Repository Interface
     *
     * @var [type]
     */
    private $patient;

    public function __construct(UtilityRepository $utilityRepository, PatientRepositoryInterface $patient)
    {
        $this->middleware('auth');
        $this->utilityRepository = $utilityRepository;
        $this->patient = $patient;
    }
    /**
     * show list of patients by view mode
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return View
     */

    public function showView()
    {
        if (Auth::user()->cant('patients.view')) return redirect()->back();
        // $patients = Patient::with('hospi', 'villes')->paginate(12);
        $patients = Patient::with('hospi', 'villes')->get();

        return view('user.patient.show_view', compact('patients'));
    }

    public function showArchives()
    {
        if (Auth::user()->cant('patients.view')) return redirect()->back();
        return view('user.patient.show', ['patients' => $this->patient->getArchived()]);
    }
    /**
     * Show all patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return View
     */
    public function index()
    {

        if (Auth::user()->cant('patients.view')) return redirect()->back();

        //$patients = $this->patient->getAvalaibles();
        $patients = Patient::with('hospi', 'villes')->orderBy('created_at', 'desc')->get();
        return view('user.patient.show', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createOnOneStep()
    {
        if (Auth::user()->cant('patients.create')) return redirect()->back();

        $pathologies   = $this->utilityRepository->getPathologies();
        $allergies     = $this->utilityRepository->getAllergies();
        $operations    = $this->utilityRepository->getOperations();
        $grossesses    = $this->utilityRepository->getGrossesse();
        $wilayas       = $this->utilityRepository->getWilayas();
        $dairasTlemcen = $this->utilityRepository->getDairasTlemcen();

        return view('user.patient.create_rapide.zero_step', compact('pathologies', 'allergies', 'operations', 'grossesses', 'wilayas', 'dairasTlemcen'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatient $request)
    {
        \LogActivity::addToLog('Patient créer');
        $patient = $this->patient->create($request);

        return redirect(route('patient.edit', $patient->id));
    }
    /**
     * Confirm reading of notifications and redirect to patient folder
     *
     * @param [type] $id
     * @param [type] $pr_risque
     * @param [type] $notif_id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    function markAsRead($id, $pr_risque, $notif_id)
    {
        Auth::user()->notifications()
            ->where('id', $notif_id)
            ->get()
            ->first()
            ->delete();

        if ($pr_risque != '_') {
            return redirect()->route('patient.intervenir', [$id, $pr_risque]);
        }

        return redirect()->route('patient.edit', $id);
    }

    /**
     * Show the patient profile , and his folder :
     * auto , traitement , medical , biological analysis , phyto  *...etc
     *
     * @param int $id
     * @param null $pr_risque
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(int $id, $pr_risque = null)
    {
        \LogActivity::addToLog('Dossier Patient  ' . $id . ' ouvert');

        if (Auth::user()->cant('patients.module')) return redirect()->back();

        $patient =  $this->patient->findByIdWithFolder($id);

        $bilans = \App\Models\Element::select('bilan')->distinct()->get();
        $pathologies = $this->utilityRepository->getPathologies();
        $grossesses  = $this->utilityRepository->getGrossesse();
        $wilayas     = $this->utilityRepository->getWilayas();

        if (isset($patient->communes))
            $dairasPatient = $this->utilityRepository->getDairaPatient($patient->communes->id);
        else
            $dairasPatient = $this->utilityRepository->getDairasTlemcen();

        //get all traitement patient
        //$traitement  = Traitement::where('patient_id', $patient->id)->get();
        //récupérer formule de calcule sc
        //$formule = FormuleSC::where('confirmed', 1)->pluck('formule')->first();

        $annotations = DB::table('users')->join('annotations', 'users.id', '=', 'annotations.user_id')
            ->where('pat_id', $id)
            ->get();
        $questionnaires = \App\Models\Questionnaire::all();
        if (!session('tab'))
            session(['tab' => 'tab_2']);
        $flag = true;
        // return $this->makeResponse('user.patient.edit1', compact('pathologies', 'patient', 'elements', 'bilans', 'Hospitalisation', 'traitement', 'annotations', 'formule', 'questionnaires'));
        return view('user.patient.edit1', compact(
            'flag',
            'annotations',
            'pathologies',
            'grossesses',
            'pr_risque',
            'patient',
            'bilans',
            'questionnaires',
            'wilayas',
            'dairasPatient'
        ));
    }

    /**
     * Update the specified patient in storage.
     *
     * @param StorePatient $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @author __KaziWhite**__SALAF4_WebDev**.
     */
    public function update(StorePatient $request, int $id)

    {
        \LogActivity::addToLog('Profile Patient ' . $id . ' modifier');

        if (Auth::user()->cant('patients.update')) return redirect()->back();

        // $compte = DB::table('comptes')->where('patient_id', '=', $id)->first();
        // if ($compte != null) {
        //     DB::table('comptes')->where('patient_id', '=', $id)->update(['tel' => $request->num_tel_1]);
        // }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300, 300)->save(public_path('/images/avatar/' . $filename));
            $request->photo = $filename;
        }
        $request->request->add(['updated_by' => $request->user()->id]);
        $id = Patient::where('id', $id)
            ->update($request->except(['_token', '_method']));
        $patient = Patient::find($id);

        if (isset($request->pathologies)) {

            foreach ($request->pathologies as $path) {
                //collect all inserted record IDs
                $path_id_array[$path] = ['type' => 'path'];
            }
            //associate patient with pathologies
            $patient->pathologies()->detach();
            $patient->pathologies()->sync($path_id_array);
        } else {
            $patient->pathologies()->detach();
        }
        if (!empty($request->famille_antecedants)) {
            # code...
            foreach ($request->famille_antecedants as $ant) {
                //collect all inserted record IDs
                $ant_id_array[$ant] = ['type' => 'ant'];
            }
            // sync with pathologies
            $patient->antecedentsFamilliaux()->detach($ant_id_array);
            $patient->antecedentsFamilliaux()->attach($ant_id_array);
        }
        $patient->allergies()->sync($request->allergies);
        $patient->operations()->sync($request->operations);

        return redirect(route('patient.edit', $patient->id))->with('message', 'Profile patient modifié avec succés !'); //or to back back()->withInput();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('patients.delete')) return redirect()->back();

        //fetch row to delete
        Patient::where('id', $id)->delete();
        DB::update("ALTER TABLE patients AUTO_INCREMENT = 1;");
        return redirect()->back()->with('message', 'Patient supprimé avec succés !');
    }

    /**
     * get Pathologies
     *
     * @return Pathologies
     * @author
     **/

    public function fetchPathologies($query)
    {
        return response()->json($this->utilityRepository->getPathologies());
    }
}
