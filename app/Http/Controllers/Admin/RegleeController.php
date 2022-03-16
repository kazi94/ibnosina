<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reglee;

use Storage;
use DB;
use Validator;

class RegleeController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$regle=Reglee::all();
        return view ('admin.regle.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


  /*  public function create()
    {
        //$regle=Reglee::all();
    }
*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
       /* if (Auth::user()->cant('reglee.create')) 
            return redirect()->back();*/
        if ($request->isMethod('POST')) {    
              /*  $messages  = ['required' => "Le champ :attribute est obligatoire", 'numeric' => "Le champ :attribute doit ètre numérique", 'unique' => "Le champ :attribute doit ètre unique ", ];
                $validator = Validator::make($request->all(), ['regle' => 'required|unique:regles', 'inf' => 'numeric|nullable', 'sup' => 'numeric|nullable', 'element' => 'string|required|unique:regles|nullable', 'classe' => 'string|nullable'],$messages);
             
                if ($validator->fails()) return $validator->messages();*/
              
               $reglee=array();
               $re = new Reglee;

               
               $re->si = $request->si;
               $re->alors = $request->alors;
               $re->commentaire = $request->commentaire;
               $re->save();
              return redirect()->back()->with('message' , 'Regle ajouté avec succés !');
               

               
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $reglee = Reglee::find($id);

        return view('admin.regle.edit1',compact('reglee'));
   
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
       /* if (Auth::user()->cant('reglee.update')) 
            return redirect()->back();*/
        $re = Reglee::find($id);
        $re->si = $request->si;
        $re->alors = $request->alors;
        $re->commentaire = $request->commentaire;
        $re->save();
     return redirect()->back()->with('message' , 'Regle modifie avec succés !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
*/
    public function destroy($id)
    {   
       /* if (Auth::user()->cant('reglee.delete')) 
            return redirect()->back();*/
        //fetch row to delete
        Reglee::where('id',$id)->delete();

        return redirect()->back()->with('message' , 'Regle supprimée avec succés !');
    }
}
