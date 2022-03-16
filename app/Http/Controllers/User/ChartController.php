<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Bilan;
use App\Models\Patient;
use Carbon\Carbon;

use App\Http\Controllers\Controller;

class ChartController extends Controller
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

    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $patient_id = DB::table('bilans')->where('id','=',$id)->pluck('patient_id');
        $element_id = DB::table('bilans')->where('id','=',$id)->pluck('element_id');
        
        
        
        $bilans = DB::table('bilans')
                            ->join('patients','patients.id','bilans.patient_id')
                            ->join('elements','elements.id','bilans.element_id')
                            
                            ->where(function ($query) use ($patient_id, $element_id) {
                                        $query->where('patient_id','=', $patient_id);
                                        $query->where('valide','=', 1);
                                        //$query->where('element_id','=', $element_id);
                                    })
                            
                            ->select('bilans.id','bilans.element_id','bilans.patient_id','elements.element','elements.minimum','elements.maximum','elements.unite','bilans.valeur','bilans.date_analyse','bilans.element_id')
                            ->get();
        
        return response()->json($bilans , 201);
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

    public function shows($id)
    {
        
    }

    public function ajax($id, $dashboard){
        
        $choix = DB::table('dashboards')
                            ->join('elements','elements.id','dashboards.element_id')
                            ->where(function ($query) use ($dashboard) {
                                        $query->where('nom','=', $dashboard);
                                    })
                            ->pluck('element');

        
        $bilans = DB::table('bilans')
                            ->join('patients','patients.id','bilans.patient_id')
                            ->join('elements','elements.id','bilans.element_id')
                            
                            ->where(function ($query) use ($id) {
                                        $query->where('patient_id','=', $id);
                                        $query->where('valide','=', 1);
                                        //$query->where('element_id','=', $element_id);
                                    })
                            ->whereIn('elements.element',$choix)
                            
                            ->select('bilans.id','bilans.element_id','bilans.patient_id','elements.element','elements.minimum','elements.maximum','elements.unite','bilans.valeur','bilans.date_analyse','bilans.element_id')
                            ->get();
        $dash = DB::table('dashboards')->where('nom','=',$dashboard)->first();
        $duree = $dash->duree;
        
        $date = Carbon::today();

        switch ($duree) {
            case 'Dernier jour':
                    $date = $date->subDay();
                    $date = $date->toDateString();
                break;
            case 'Derniere semaine':
                $date = $date->subWeek();
                $date = $date->toDateString();
                break;
            case 'Dernier mois':
                $date = $date->subMonth();
                $date = $date->toDateString();
                break;
            case 'Derniere hospitalisation':
                $hospitalisation = DB::table('hospitalisations')->where('patient_id','=',$id)->whereNotNull('date_sortie')->orderBy('date_sortie','desc')->first();
                if(!empty($hospitalisation) && $hospitalisation->date_sortie >= $date){    
                    $date = $hospitalisation->date_admission;
                }else{
                    $hospitalisation = DB::table('hospitalisations')->where('patient_id','=',$id)->whereNull('date_sortie')->orderBy('date_admission', 'desc')->first();    
                    if(!empty($hospitalisation)){
                        $date = $hospitalisation->date_admission;
                    }else{
                        $date = $date->subMonth();
                        $date = $date->toDateString();
                    }
                }
                break;
            default:
                $date = $date->subDay();
                $date = $date->toDateString();
                break;
        }

        $data = ['bilans'=>$bilans,'choix'=>$choix, 'duree'=>$date];
        return $data;
    }
}
