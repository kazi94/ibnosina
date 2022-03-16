<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suivi;


use Storage;
use DB;
use Validator;

class SuiviController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.regle.create');
    }



public function store(Request $request)
    {
        if ($request->isMethod('POST')) {    
                          
               $suivi = new Suivi;

               $suivi->si = $request->si;
               $suivi->commentaire = $request->commentaire;
               $suivi->niveau = $request->niveau;
               if(isset($request->envoie) && $request->envoie == 'sms')
               {
                    $suivi->envoie = $request->envoie;
               }
               $suivi->save();
              return redirect()->back()->with('message' , 'Regle ajouté avec succés !');
               

    }
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
        $suivi = Suivi::find($id);

        return view('admin.regle.edit3',compact('suivi'));
   
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
               $suivi = Suivi::find($id);
               $suivi->si = $request->si;
               $suivi->commentaire = $request->commentaire;
               $suivi->niveau = $request->niveau;
               

               
               $suivi->save();
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
        //fetch row to delete
        Suivi::where('id',$id)->delete();

        return redirect()->back()->with('message' , 'Regle supprimée avec succés !');
    }


}