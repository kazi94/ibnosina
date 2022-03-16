<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\PrescriptionExamen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PrescriptionType;

class PrescriptionExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "fdsfsdfds";
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
        $res = [];
        foreach ($request->checkedElements as $key => $val) {
            if ($val) {
                $res[] = $request->elements_id[$key];
            }
        }


        $p = PrescriptionType::create([
            'name' => $request->name,
            'type' => 'examen',
            'service' => $request->service,
            // 'elements' => implode(',', $res)
        ]);
        foreach ($res as $val) {
            $ps = new PrescriptionExamen;
            $ps->element_id = $val;
            $ps->prescription_type_id  = $p->id;
            $ps->save();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\PrescriptionExamen  $prescriptionExamen
     * @return \Illuminate\Http\Response
     */
    public function show($prescriptionExamen)
    {
        $pres = PrescriptionExamen::where('prescription_type_id', $prescriptionExamen)->with('element')->get();
        $pres = $pres->map(function ($el) {
            return $el->element;
        });
        return response()->json($pres, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\PrescriptionExamen  $prescriptionExamen
     * @return \Illuminate\Http\Response
     */
    public function edit($prescriptionExamen)
    {
        return response()->json(PrescriptionType::with('examensType.element')->findOrFail($prescriptionExamen), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\PrescriptionExamen  $prescriptionExamen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $prescriptionExamen)
    {
        // create prescription type
        $pres_type = PrescriptionType::where('id', $prescriptionExamen)
            ->update([
                'type' => 'examen',
                'service' => $request->service,
                'name' => $request->name
            ]);
        $pres_type = PrescriptionType::find($prescriptionExamen);
        // delete all lignes prescription
        $pres_type->examensType()->delete();

        $res = [];
        foreach ($request->checkedElements as $key => $val) {
            if ($val) {
                $res[] = $request->elements_id[$key];
            }
        }
        foreach ($res as $val) {
            $ps = new PrescriptionExamen;
            $ps->element_id = $val;
            $ps->prescription_type_id  = $pres_type->id;
            $ps->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\PrescriptionExamen  $prescriptionExamen
     * @return \Illuminate\Http\Response
     */
    public function destroy($prescriptionExamen)
    {
        $deleted = PrescriptionType::where('id', $prescriptionExamen)->delete();

        return redirect(route('prescription-type.index'))->with('message', 'Prescription type supprimée avec succés !');
    }
}
