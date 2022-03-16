<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\travail;

class TravailController extends Controller
{
    public function store(Request $request)
    {
        $travail = new travail;
        $travail->nom = $request->travail;
        $travail->save();
        return redirect()->back()->with('message', 'travail ajouté avec succés !');;
    }
    public function destroy($id)
    {
        travail::where('id', $id)->delete();

        //redirect ot show page with success
        return redirect()->back()->with('message', 'le travail est supprimé avec succés !');
    }
    public function getTravail($id)
    {

        $ho = travail::find($id);

        return response()->json([
            $ho
        ]);
    }
    public function update(Request $request, $id)
    {
        $ho = travail::find($id);
        $ho->nom = $request->travail;
        $ho->save();

        return redirect()->back()->with('message', 'travail modifie avec succés !');
    }
}
