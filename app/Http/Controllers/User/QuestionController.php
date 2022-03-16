<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
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
    if (Auth::user()->cant('questionaires.create')) 
            return redirect()->back()->with('message' , 'Action non autorisée !');
               $et = new Educationtherapeutique;
               $et->created_by = $request->user()->id;
               $et->patient_id=$request->patient_id;
               $et->type = $request->type;
               $et->description = $request->notes;
               $et->date_et = $request->date_et;
               $et->save();

            return redirect()->back()->with('message' , 'Questionnaire ajouté avec succés !');;
    }

    protected function store_auto (Request $request ) {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('questionaires.delete')) 
            return redirect()->back()->with('message' , 'Action non autorisée !');
        //fetch row to delete
        Question::where('id',$id)->delete();

        return redirect()->back();
    }
}
