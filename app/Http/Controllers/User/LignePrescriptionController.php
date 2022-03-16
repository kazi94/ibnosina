<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared;
use App\Models\Ligneprescription;
use DB;
use Validator;
use Auth;
use DateTime;

class LignePrescriptionController extends Controller
{


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stopInjection(Request $req, $line_id)
    {
        try {
            $line = Ligneprescription::find($line_id);
            $line->update(
                [
                    'comment' => $req->comment,
                    'stopped' => true,
                    'stopped_at' => date('Y-m-d H:i:s')
                ]
            );

            return response()->json("Administration du Médicament " . $line->medicament->SP_NOM . " arrétée", 200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
            //throw $th;
        }
    }
    /**
     * update injected value of ligne prescription
     *
     *
     * @param  $line_id 
     * @param  $isChecked value of injected 0 or 1
     * @param  $prise  'matin'/ 'midi' / 'soir' / 'coucher'
     * @return message
     **/
    public function updateInjectedValue($line_id, $isChecked, $prise)
    {
        $msg = $isChecked ? "Médicament Administrer au patient" : "Médicament <b>non</b> dministrer au patient";
        $type = $isChecked ? "success" : "error";
        // update the injected value
        $line = LignePrescription::find($line_id);
        $earlier = new DateTime($line->created_at->format('Y-m-d'));
        $today = new DateTime(date('Y-m-d'));
        $difference = $earlier->diff($today);
        $day_j = $difference->d; // jours
        $line->injections()->create([
            'injected' => $isChecked,
            'injected_at' => date('Y-m-d H:i:s'),
            'injected_by' => Auth::user()->id,
            'prise' => $prise,
            'day_j' => $day_j
        ]);


        // $line->injections()->updateOrCreate(
        //     ['prise' => $prise],
        //     [
        //         'injected' => $isChecked,
        //         'injected_at' => date('Y-m-d H:i:s'),
        //         'injected_by' => Auth::user()->id,
        //     ]
        // );

        return response()->json([
            "msg" => $msg,
            "type" => $type
        ], 201);
    }
}
