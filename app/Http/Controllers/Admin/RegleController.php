<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regle;
use DB;
use Validator;

class RegleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //redirect table to show.blade
        return view ('admin.regle.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        if ($request->isMethod('POST')) {

             $regle             = new Regle;
             $regle->regle      = $request->regle;
             $regle->type_regle = $request->type_regle;

             if ($request->type_regle == 'patient') {
                
                $messages  = ['required' => "Le champ :attribute est obligatoire", 'numeric' => "Le champ :attribute doit ètre numérique", 'unique' => "Le champ :attribute doit ètre unique ", ];
                $validator = Validator::make($request->all(), ['regle' => 'required|unique:regles', 'inf' => 'numeric|nullable', 'sup' => 'numeric|nullable', 'element' => 'string|required|unique:regles|nullable', 'classe' => 'string|nullable'],$messages);
                
                if ($validator->fails()) return $validator->messages();
                
                $regle->element = $request->element;
                $regle->inf     = $request->inf;
                $regle->sup     = $request->sup;
                $regle->classe_id  = $request->classe_id;
                $regle->active  = '1';
                $regle->save();
                       
                for ($i=0; $i < count($request->medicament_dci_id); $i++) 
                   { 
                    if ($request->medicament_dci_id[$i] != null) 
                       DB::table('regle_medicament')->insert(
                        [
                            'regle_id'      => $regle->id ,
                            'medicament_id' =>$request->medicament_dci_id[$i]
                        ]
                        );
                    }                 
                    
            } 
                else {

                    $messages  = ['required' => "Le champ :attribute est obligatoire", 'unique' => "Le médicament/classe est déja renseigné", ];
                    if (isset($request->classe_id)) {
                    $validator = Validator::make($request->all(), ['classe_id' => 'unique:regles' ],$messages);
                        
                    } else {
                    $validator = Validator::make($request->all(), [ 'mmte_id' => 'unique:regles'],$messages);

                    }

                    if ($validator->fails()) return $validator->messages();

                    $regle->mmte_id = $request->mmte_id;
                    $regle->active  = '1';
                    $regle->save();
                    if (isset($request->classe_id)) {
                        $regle             = new Regle;
                        $regle->regle      = $request->input('regle','autre');
                        $regle->type_regle = $request->type_regle;                        
                        $regle->classe_id     = $request->classe_id;
                        $regle->active     = '1';
                        $regle->save();
                    }
                }
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $regle = Regle::find($id);

        return view('admin.regle.edit',compact('regle'));
    }
    public function edits($regle_id)
    {
        $regle = Regle::find($regle_id);
        $regle->active = $_GET['active'];
        $regle->save();
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
        $regle          = Regle::find($id);
        $regle->regle   = $request->regle;
        $regle->element = $request->element;
        $regle->inf     = $request->inf;
        $regle->sup     = $request->sup;
        $regle->classe_id  = $request->classe_id;
        $regle->save();

        if ($request->has('medicament_dci_id')) 
        {
            $regle->medicament()->sync($request->medicament_dci_id);               
        }  

        return redirect(route('admin.regle.create'))->with('message','Modification effectuée avec succées !');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fetch row to delete
        Regle::where('id',$id)->delete();

        return redirect(route('regle.index'))->with('message' ,'Régle supprimé avec succés !');
    }
}
