<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Element;
use DB;
use Validator;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elements = Element::all();

        return view('admin.biologie.show', compact('elements'));
    }
    public function getAll()
    {
        $elements = Element::all();

        return response()->json($elements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.biologie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Le champ :attribute est obligatoire',
            'max' => 'Le champ :attribute maximum :max',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'bilan' => 'max:60',
                'element' => 'required|max:50|string',
            ],
            $messages
        );
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $element = new Element();

        $element->element = ucfirst($request->element);
        $element->bilan = $request->bilan;
        $element->unite = $request->unite;
        $element->minimum = $request->min;
        $element->maximum = $request->max;
        $element->sexe = $request->sexe;
        // $element->special = $request->spécial;

        // store in table
        $element->save();

        // redirect to show page
        return redirect(route('element.index'))->with('message', 'L\'element ' . $request->element . ' créer avec succés !');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    public function avoir()
    {
        //récuperer l'élement du bilan selectionné
        if (isset($_POST['bilan'])) {
            $result = DB::table('elements')
                ->distinct()
                ->select('element')
                ->where('bilan', $_POST['bilan'])
                ->get();
        } elseif (isset($_POST['someData'])) {
            $result = DB::table('elements')
                ->distinct()
                ->select('bilan')
                ->get();
        } else {
            $result = DB::table('elements')
                ->select('unite', 'id')
                ->where('element', $_POST['element'])
                ->get();
        }

        return $result;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //fetch record's element with his id
        $element = Element::find($id);

        //get file
        // $myFile = "js/json/general.json";

        // //put chmod permission
        // $fh = fopen($myFile, 'r') or die("can't open file");

        // while ($line = fgets($fh)) {
        // // <... Do your work with the line ...>
        // $lines = $line;
        // }

        // fclose($fh);

        //redirect to edit page , with record's id to edit
        return view('admin.biologie.edit', compact('element'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Le champ :attribute est obligatoire',
            'max' => 'Le champ :attribute maximum :max',
            'min' => 'Le champ :attribute minimum :min',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'bilan' => 'max:60',
                'element' => 'string',
                'unite' => 'max:10',
                // 'min' => 'max:5',
                // 'max' => 'max:5',
            ],
            $messages

        );
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $element = Element::findOrFail($id); // fetch row from id

        $element->bilan = $request->bilan; // if bilan field is empty , the seond argument will beplaced
        $element->unite = $request->unite;
        $element->minimum = $request->min;
        $element->maximum = $request->max;
        // $element->special = $request->spécial;

        $element->save(); // persist fields in the table 'roles'

        return redirect(route('element.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Element::where('id', $id)->delete();

        //redirect ot show page with success
        return redirect()
            ->back()
            ->with('message', 'l\'element est supprimer avec succés !');
    }

    protected function getElement($phrase)
    {
        $result = DB::table('elements')
            ->select('element', 'minimum', 'maximum', 'unite')
            ->where('element', 'like', '%' . $phrase . '%')
            ->get();
        return $result;
    }

    public function getElements($bilan)
    {
        $elements = Element::where('bilan', $bilan)->get();

        return response()->json($elements);
    }
}
