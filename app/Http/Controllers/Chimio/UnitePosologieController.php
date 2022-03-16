<?php

namespace App\Http\Controllers\Chimio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelsChimio\unite;
use App\ModelsChimio\FormuleSC;
use DB;
use App\ModelsChimio\Medi_para;

class UnitePosologieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formules = FormuleSC::All();
        $formule_utilise = FormuleSC::where('confirmed', 1)->first();
        
        $unites = unite::all();
        $para = Medi_para::all();
        
        return view('chimio/parametres',compact('formules','formule_utilise','unites','para'));
    }

    function activerFormule(Request $request){
        $id = $request->input('formule');
        $supp = $request->input('pp');
        if ($supp !='') {
            $get_all_formules = FormuleSC::All();
            foreach ($get_all_formules as $f) {
                if ($f->id == $id) {
                   $f->confirmed = 1;
                   $f->save();
                }else{
                    $f->confirmed = 0;
                    $f->save();
                }
            }
        }else{
            FormuleSC::destroy($id);
        }
        return response()->json('succès');
    }
    function addFormule(Request $request){
         $formule = $request->input('vv');
         $confirmed = $request->input('confirmed');
         $formulee = new FormuleSC();
         $formulee->formule = $formule;
         if ($confirmed) {
            $get_all_formules = FormuleSC::All();
            foreach ($get_all_formules as $f) {
                $f->confirmed = 0;
                $f->save();
            }
            $formulee->confirmed = 1;
         }else{
            $formulee->confirmed = 0;
         }
         $formulee->save();
         return response()->json('succès');
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

    public function addUnite(Request $request){
        $unite = new unite();

        $unite->intitule = $request->input('unite_in');
        $unite->unite = $request->input('unite');
        /*var_dump($request->input('unite_in'));var_dump($request->input('unite'));
        dd('fin');*/
        $unite->save();

        return response()->json('succès');
    }

    public function deleteunite($id){
        unite::destroy($id);
        return response()->json('succès');
    }
    public function addpara(Request $request){  
        $id_medi = DB::table('sp_specialite')
                        ->where('SP_NOM',$request->input('dci_nom'))
                        ->pluck('SP_CODE_SQ_PK');
        $volume = $request->input('volume_medi');
        $sol_r = $request->input('sol_r'); 
        $sol_d = $request->input('sol_d');
        $e1 = $request->input('e1');
        $e2 = $request->input('e2');
        $e3 = $request->input('e3');
        $e4 = $request->input('e4');

        $para_medi = new Medi_para();
        $para_medi->medicament_id = $id_medi[0];
        $para_medi->volume_medi = $volume;
        $para_medi->solvant_recon = $sol_r;
        $para_medi->solvant_dilu = $sol_d;
        $para_medi->e1 = $e1;
        $para_medi->e2 = $e2;
        $para_medi->e3 = $e3;
        $para_medi->e4 = $e4;
    
        $para_medi->save();

        return redirect(route('para'))->with('tt','parametre ajouté');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
