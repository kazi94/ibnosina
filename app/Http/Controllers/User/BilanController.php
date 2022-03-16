<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBilan;
use App\Models\Bilan;
use App\Models\Prescription;
use DB;
use Validator;
use Auth;

class BilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bilan = Bilan::all();

        return response()->json([
            $bilan
        ]);
    }
    /**
     * show mes demandes d'examens de tt les patients du service
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return View
     */
    public function getExamens()
    {
        if (Auth::user()->cant('analyses_biologique.executeRequest')) return redirect()->back();
        $result = $this->getDemandes('Exam in progress');

        // les demandes d'examens faite par l'utilisateur
        $history = $this->getDemandes('Exam done');


        return view('user.examen.show', compact('result', 'history'));
    }

    public function getDemandes($state)
    {
        return Prescription::with([
            'prescripteur',
            'patient.hospi',
        ])
            ->whereEtats($state)
            ->orderBy('date_prescription', 'desc')
            ->get();
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
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function store(StoreBilan $request)
    {
        if (Auth::user()->cant('analyses_biologique.create'))
            return redirect()->back();

        $id = $this->storeBilan($request);
        return redirect()->back()->with(['message' => 'Demande d\'examen envoyée !', 'tab' => 'tab_3']);
    }

    public function storeBilan($data)
    {
        $presc = new Prescription;
        $presc->date_prescription = $data->date_prescription;
        $presc->type = $data->type;
        $presc->note = $data->note;
        $presc->created_by   = Auth::user()->id;
        $presc->patient_id   = $data->patient_id;
        $presc->consultation_id   = $data->consultation_id;
        $presc->etats = 'Exam in progress';
        $presc->save();

        if ($data->type == 'bilan') {
            for ($i = 0; $i < count($data->checkedElements); $i++) {
                if ($data->checkedElements[$i]) {
                    $bilan = new Bilan;
                    // $bilan->date_analyse = $data->date_analyse;
                    // $bilan->valeur       = $data->valeurs[$i];
                    // $bilan->laboratoire  = $data->laboratoire;
                    $bilan->created_by   = Auth::user()->id;
                    $bilan->patient_id   = $data->patient_id;
                    $bilan->type   = $data->type;
                    $bilan->element_id   = $data->elements_id[$i];
                    $bilan->prescription_id   = $presc->id;
                    $bilan->save();
                }
            }
        } elseif ($data->type == 'radio') {
            $bilan = new Bilan;
            // $bilan->comment = $data->note;
            $bilan->created_by   = Auth::user()->id;
            $bilan->patient_id   = $data->patient_id;
            $bilan->type   = $data->type;
            $bilan->prescription_id   = $presc->id;
            $bilan->save();
        }
        return $presc->id;
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getDemande($id)
    {
        $demandes = Bilan::with('element')->where('prescription_id', $id)->get();

        return response()->json($demandes, 201);
    }
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getPrescription($id)
    {
        return response()->json(Prescription::with('bilans.element')->find($id), 200);
    }
    public function show($bilan)
    {

        // $result = DB::select('select element from elements where bilan = ?', $bilan);
        // return $result;
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
        // return $request->all();
        if (Auth::user()->cant('analyses_biologique.update'))
            return redirect()->back();
        if ($request->type != "bilan") { // is Radio request
            $bilan = Bilan::where('prescription_id', $id)->first();

            if (isset($request->fichier)) { // is Radio request
                $extension = $request->file('fichier')->extension();
                $fileNameToStore = '/img/radios/' . time() . '.' . $extension;
                $path = $request->file('fichier')->storeAs('/public/img/radios/', time() . "." . $extension);
                $bilan->fichier = $fileNameToStore;
            }
            $bilan->laboratoire = $request->laboratoire;
            $bilan->is_imagery = $request->is_imagery;
            $bilan->attack_rate = $bilan->is_imagery ? $request->attack_rate  : '';
            $bilan->commentaire = $request->comment;
            $bilan->date_analyse = $request->date_analyse;
            $bilan->updated_by = Auth::user()->id;
            $bilan->save();
        } else {   // is Bilan request
            for ($i = 0; $i < count($request->lignes_id); $i++) {
                if ($request->valeurs[$i]) {
                    $bilan = Bilan::find($request->lignes_id[$i]);
                    $bilan->date_analyse = $request->date_analyse;
                    $bilan->valeur = $request->valeurs[$i];
                    $bilan->laboratoire = $request->laboratoire;
                    $bilan->updated_by = $request->user()->id;
                    $bilan->save();
                }
            }
        }

        // Mark the exam request as done
        $presc = Prescription::find($id);
        $presc->etats = 'Exam done';
        $presc->updated_by = Auth::user()->id;
        $presc->save();

        return redirect()->back()->with(['message' => 'Examens modifiés avec succés !', 'tab' => 'tab_3']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bilan = Bilan::find($id);
        if ($bilan->fichier)
            // delete file from storage
            Storage::delete("public/" . $bilan->fichier);

        if (Auth::user()->cant('analyses_biologique.delete'))
            return redirect()->back();
        //fetch row to delete
        try {
            $deleted = Bilan::where('id', $id)->delete();
            // reset auto increment to the last id before deleted
            DB::update("ALTER TABLE bilans AUTO_INCREMENT = 1;");
        } catch (Exception $e) {
            return $e;
        }
        return redirect()->back()->with(['message' => 'Examen supprimer avec succés !', 'tab' => 'tab_3']);


        // return $deleted ?  response()->json(['response' => 'success' , 'msg' => 'Bilan supprimé avec succés !'] , 200) : 'Erreur dans la suppression';
    }
    /**
     * update element of exams
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function updateElement(Request $request, $id)
    {
        $element = Bilan::find($id);
        $element->valeur = $request->valeur;
        $element->date_analyse = $request->date_analyse;
        $element->laboratoire = $request->laboratoire;
        $element->commentaire = $request->commentaire;
        $element->save();

        return redirect()->back()->with(['message' => 'Element modifiés avec succés !', 'tab' => 'tab_3']);
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getElement($id)
    {
        return response()->json(Bilan::find($id), 201);
    }
}
