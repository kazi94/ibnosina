<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\Consultation;
use App\Models\Hospitalisation;
use App\Models\Patient;
use App\User;
use DB;
use Validator;
use Auth;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('stats.show');
    }

    /**
     * Count Prescriptions over time
     *
     * @return void
     * @author 
     **/
    public function getPrescriptions($from = null, $to = null)
    {

        if (isset($from) && isset($to))
            $results = Prescription::select('date_prescription', DB::raw('count(id) as nbr'))
                ->groupBy('date_prescription')
                ->whereBetween('date_prescription', [$from, $to])
                ->get();
        else
            $results = Prescription::select('date_prescription', DB::raw('count(id) as nbr'))
                ->groupBy('date_prescription')
                ->get();
        return Response()->json($results);
    }

    /**
     * Count Patients over time
     *
     * @return void
     * @author 
     **/
    public function getPatients($from = null, $to = null)
    {


        if (isset($from) && isset($to))
            $results = Patient::select(DB::raw("cast(created_at as date) as date_created"), DB::raw('count(id) as nbr'))
                ->whereBetween(DB::raw("cast(created_at as date)"), [$from, $to])
                ->groupBy("date_created")
                ->get();
        else
            $results = Patient::select(DB::raw("cast(created_at as date) as date_created"), DB::raw('count(id) as nbr'))
                ->groupBy("date_created")
                ->get();
        return Response()->json($results);
    }

    /**
     * Count signes formelles over time
     *
     * @return void
     * @author 
     **/
    public function getConsultations($from = null, $to = null)
    {
        if (isset($from) && isset($to))
            $results = DB::table('consultation_signe')
                ->join('consultations', 'consultation_id', 'consultations.id')
                ->join("signes", 'signe_id', 'signes.id')
                ->whereBetween("date_consultation", [$from, $to])
                ->select(DB::raw("count(consultation_id) as nbr"), "signe_id", "name")
                ->groupBy("signe_id")->get();
        else
            $results = DB::table('consultation_signe')
                ->join("signes", 'signe_id', 'id')
                ->select(DB::raw("count(consultation_id) as nbr"), "signe_id", "name")
                ->groupBy("signe_id")->get();
        return Response()->json($results);
    }
    /**
     * retourne tout les patients/prescriptions/users du service
     *
     * @return void
     * @author 
     **/
    public function getAll()
    {
        $users = User::where('service', Auth::user()->service)->count();
        $patients = Patient::whereDate('created_at',  Carbon::now()->toDateString())->count();


        $deaths = Hospitalisation::where('date_sortie', Carbon::now()->toDateString())
            ->whereService(Auth::user()->service)
            ->where('motif_sortie', 'décés')
            ->count();
        $exits = Hospitalisation::where('date_sortie', Carbon::now()->toDateString())
            ->whereService(Auth::user()->service)
            ->whereIn('motif_sortie', ['hopital', 'autre'])
            ->count();

        $prescriptions = Prescription::whereDate('created_at',  Carbon::now()->toDateString())->count();

        return response()->json([
            'users' => $users,
            'patients' => $patients,
            'deaths' => $deaths,
            'exits' => $exits,
            'prescriptions' => $prescriptions,
        ]);
    }
    /**
     * Return number of each type of pharmaceuticual problem
     * encountred in all patients
     * @return void
     * @author _KaziWhite**__SALAF4_WebDev**
     **/
    public function getProblems($from = null, $to = null)
    {



        if (isset($from) && isset($to))
            $results = Patient::with(['interventions' => function ($q) use ($from, $to) {
                return $q->whereBetween(DB::raw("cast(date_ip as date)"), [$from, $to]);
            }, 'interventions.countProblems'])->get();
        else {
            $results = Patient::with('interventions.countProblems')->get();
        }
        foreach ($results as $value)
            foreach ($value->interventions as $val)
                foreach ($val->countProblems as $el)
                    for ($i = 0; $i < $el->compt; $i++)
                        $resultat[] = explode(',', $el->problemes);

        $collection = collect($resultat);
        $collapsed = $collection->collapse();
        return array_count_values($collapsed->toArray());
    }
    /**
     * Return number of each type of Pharmaceutical
     * intervention on all patients
     * @return void
     * @author _KaziWhite**__SALAF4_WebDev**
     **/
    public function getInterventionsPharmaceutique($from = null, $to = null)
    {
        if (isset($from) && isset($to))
            $results = Patient::with(['interventions' => function ($q) use ($from, $to) {
                return $q->whereBetween(DB::raw("cast(date_ip as date)"), [$from, $to]);
            }, 'interventions.countIp'])->get();
        else {
            $results = Patient::with('interventions.countIp')->get();
        }

        foreach ($results as $value) {
            foreach ($value->interventions as $val) {
                foreach ($val->countIp as $el) {
                    $resultat[] = array(

                        'compt' => $el->compt,
                        'ip'    => $el->ip,
                    );
                }
            }
        }

        return $resultat;
    }
    /**
     * Return Statistical result of Pharmaceutic analyses
     * of all patients
     * @return \Illuminate\Http\Response
     * @author _KaziWhite**__SALAF4_WebDev**
     */
    public function getAnalysesPharmaceutique($from = null, $to = null)
    {


        if (isset($from) && isset($to))

            $results = DB::table('statistiques')
                ->groupBy('type_effet')
                ->whereBetween("date_analyse", [$from, $to])
                ->select('type_effet', 'date_analyse', DB::raw('count(id) as nb'))
                ->get();
        else
            //count total for each effect type
            $results = DB::table('statistiques')
                ->groupBy('type_effet')
                ->select('type_effet', 'date_analyse', DB::raw('count(id) as nb'))
                ->get();
        return Response()->json($results);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * get All prescription à risque by date when etats == 'risque'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionsRisk($from = null, $to = null)
    {

        if (isset($from) && isset($to))
            $results = Prescription::Where('etatAnalyseInterne', 'risqueInterne')
                ->whereNotNull('date_etats_risque')
                ->select('date_etats_risque as d_risque', DB::raw('count(id) as nbr'))
                ->whereBetween('date_etats_risque', [$from, $to])
                ->groupBy('d_risque')
                ->get();
        else
            $results = Prescription::Where('etatAnalyseInterne', 'risqueInterne')
                ->whereNotNull('date_etats_risque')
                ->select('date_etats_risque as d_risque', DB::raw('count(id) as nbr'))
                ->groupBy('d_risque')
                ->get();
        return Response()->json($results);
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
    public function destroy($id)
    {
    }
}
