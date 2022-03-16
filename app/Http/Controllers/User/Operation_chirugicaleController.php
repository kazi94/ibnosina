<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operation_chirugicale;

class Operation_chirugicaleController extends Controller
{
    public function store(Request $request)
    {
        $operation = new Operation_chirugicale;
        $operation->nom = $request->operation;
        $operation->save();
        return redirect()->back()->with('message', 'Operation ajouté avec succés !');;
    }
    public function destroy($id)
    {
        Operation_chirugicale::where('id', $id)->delete();

        //redirect ot show page with success
        return redirect()->back()->with('message', 'loperation chirurgicale est supprimé avec succés !');
    }
    public function getOperation($id)
    {

        $ho = Operation_chirugicale::find($id);

        return response()->json([
            $ho
        ]);
    }
    public function update(Request $request, $hospitalisation)
    {
        $ho = Operation_chirugicale::find($hospitalisation);
        $ho->nom = $request->operation;
        $ho->save();

        return redirect()->back()->with('message', 'Operation chirugicale modifie avec succés !');
    }
}
