<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Post;


use Storage;
use DB;
use Validator;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$edu=Education::all();
        return view('admin.regle.create');
    }



    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {


            //$education=array();
            $edu = new Education;


            $edu->si = $request->si;
            $edu->titre = $request->titre;
            $edu->commentaire = $request->commentaire;
            $edu->maladie = $request->maladie;
            $edu->effet = $request->effet;
            $edu->voyage = $request->voyage;
            $edu->act = $request->act;
            $edu->utilisation = $request->utilisation;
            $edu->effet_indiserable = $request->effet_indiserable;
            $edu->regime = $request->regime;
            $edu->url = $request->url;
            //  $edu->pdf = $request->pdf;
            if ($request->pdf != null) {
                $file = $request->pdf;
                $name = $file->getClientOriginalName();
                if ($file->move('pdfs', $name)) {

                    $edu->pdf = $name;
                }
            }



            $edu->save();
            return redirect()->back()->with('message', 'Regle ajouté avec succés !');
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
        $education = Education::find($id);
        // \Log::info($education->id."et si ".$education->si);

        //return redirect()->back()->with('education',$education->si);
        return response()->json(['education' => $education]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $education = Education::find($id);
        return view('admin.regle.edit2', compact('education'));
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
        $education = Education::find($id);
        $education->si = $request->si;
        $education->commentaire = $request->commentaire;
        $education->maladie = $request->maladie;
        $education->effet = $request->effet;
        $education->voyage = $request->voyage;
        $education->act = $request->act;
        $education->utilisation = $request->utilisation;
        $education->effet_indiserable = $request->effet_indiserable;
        $education->regime = $request->regime;
        $education->url = $request->url;

        if ($request->pdf != null) {
            $file = $request->pdf;
            $name = $file->getClientOriginalName();
            if ($file->move('pdfs', $name)) {

                $education->pdf = $name;
            }
        }



        $education->save();
        return redirect()->back()->with('message', 'Regle modifie avec succés !');
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
        Education::where('id', $id)->delete();

        return redirect()->back()->with('message', 'Regle supprimée avec succés !');
    }
}
