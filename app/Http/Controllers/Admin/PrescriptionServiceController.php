<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\PrescriptionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PrescriptionType;

class PrescriptionServiceController extends Controller
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
        // create prescription type
        $pres_type = PrescriptionType::create([
            'type' => 'service',
            'service' => $request->service,
            'name' => $request->name
        ]);
        // create prescription service
        $lines = json_decode($request->lines, true);
        $pres_type->servicesType()->createMany($lines);

        return response()->json("success", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  $prescriptionService
     * @return \Illuminate\Http\Response
     */
    public function show($prescriptionService)
    {
        $pres = PrescriptionService::where('prescription_type_id', $prescriptionService)->with('medicament')->get();
        $pres->map(function ($e) {
            $e->medicament_dci = $e->medicament->SP_NOM;
            return $e;
        });
        return response()->json($pres, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrescriptionService  $prescriptionService
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prescription = PrescriptionType::with('servicesType.medicament')->find($id);
        $prescription->servicesType->map(function ($e) {
            $e->medicament_dci = $e->medicament->SP_NOM;
            return $e;
        });
        return response()->json($prescription, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $prescriptionService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $prescriptionService)
    {
        // create prescription type
        $pres_type = PrescriptionType::where('id', $prescriptionService)
            ->update([
                'type' => 'service',
                'service' => $request->service,
                'name' => $request->name
            ]);
        $pres_type = PrescriptionType::find($prescriptionService);
        // delete all lignes prescription
        $pres_type->servicesType()->delete();
        $lines = json_decode($request->lines, true);
        $pres_type->servicesType()->createMany($lines);
        return response()->json("success", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrescriptionService  $prescriptionService
     * @return \Illuminate\Http\Response
     */
    public function destroy($prescriptionService)
    {
        $deleted = PrescriptionType::where('id', $prescriptionService)->delete();

        return redirect(route('prescription-type.index'))->with('message', 'Prrescription type supprimée avec succés !');
    }
}
