<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationTherapeutique;
use App\Models\Educationtherapeutique;
use App\Models\Patient;
use Auth;
use Storage;

class EducationTherapeutiqueController extends Controller
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
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function show($id)
    {
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
    public function store(StoreEducationTherapeutique $request)
    {
        if (Auth::user()->cant('educations_therapeutique.create'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        $et              = new Educationtherapeutique;
        $et->created_by  = $request->user()->id;
        $et->patient_id  = $request->patient_id;
        $et->type        = $request->type;
        $et->description = $request->notes;
        $et->date_et     = $request->date_et;
        if (isset($request->fichier)) { //to throw the exception of there is undefined offset of file
            $extension = $request->file('fichier')->extension();
            $fileNameToStore = '/img/educations/' . time() . '.' . $extension;
            $path = $request->file('fichier')->storeAs('/public/img/educations/', time() . "." . $extension);
            $et->fichier = $fileNameToStore; // store the path of file in database
            // if (Storage::mimeType($path) == 'image/png' || Storage::mimeType($path) == 'image/jpeg') // Stocker tout les format des images à une seul et unique extension
            //     $file->move(public_path() . '/images/', $et->id . '.jpeg');
            // else if (Storage::mimeType($path) == "audio/mpeg") { //store other authorized format files
            //     $file->move(public_path() . '/sounds/', $et->id . '.mp3');
            // } else if (Storage::mimeType($path) == 'video/mp4') { //store other authorized format files
            //     $file->move(public_path() . '/videos/', $et->id . '.mp4');
            // }

            //Storage::delete($path);
        }

        $et->save();

        return redirect()->back()->with(['message' => 'Education thérapeutique ajoutée avec succés !', 'tab' => 'tab_9']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('educations_therapeutique.delete'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        $edu = Educationtherapeutique::find($id);
        if ($edu->fichier)
            // delete file from storage
            Storage::delete("public/" . $edu->fichier);
        $deleted = $edu->delete();
        return redirect()->back()->with(['message' => 'Education thérapeutique supprimée avec succés !', 'tab' => 'tab_9']);
    }


    /**
     * Show History of Therapeutical Education
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return View
     */
    public function showEducations()
    {
        $patients = Patient::all();
        return view('user.pharmacien.education.todo', compact('patients'));
    }
}
