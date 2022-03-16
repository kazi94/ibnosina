<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\act_medicale;

class Act_medicaleController extends Controller
{
    public function store(Request $request)
    {
        $act = new act_medicale;
        $act->nom = $request->act;
        $act->save();
        return redirect()->back()->with('message', 'Act Medicale ajouté avec succés !');;
    }
    public function destroy($id)
    {
        act_medicale::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE act_medicales AUTO_INCREMENT = 1;");
        //redirect ot show page with success
        return redirect()->back()->with('message', 'lact medicale est supprimé avec succés !');
    }
    public function getAct($id)
    {

        $ho = act_medicale::find($id);

        return response()->json([
            $ho
        ]);
    }
    public function update(Request $request, $hospitalisation)
    {
        $ho = act_medicale::find($hospitalisation);
        $ho->nom = $request->act;
        $ho->save();

        return redirect()->back()->with('message', 'act medicale modifie avec succés !');
    }
    public function getAll()
    {
        $elements = act_medicale::all();

        return response()->json([
            $elements
        ]);
    }
}
