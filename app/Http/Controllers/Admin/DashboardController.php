<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Dashboard;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.graphe.create');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $oldElement = DB::table('dashboards')->where('nom', $request->nom)->exists();

        if ($oldElement == true) {
            return redirect()->back()->with('message', 'Erreur d\'ajout, nom existe deja!');
        }
        foreach ($request->elements as $element) {
            DB::table('dashboards')->insert([
                "nom"         => $request->nom,
                "description" => $request->desc,
                "duree"       => $request->duree,
                "element_id"  => $element
            ]);
        }
        return redirect()->back()->with('message', 'Dashbord Ajouté avec succés !');
    }

    public function destroy($nom)
    {
        Dashboard::where('nom', $nom)->delete();

        //redirect ot show page with success
        return redirect()->back()->with('message', 'le dashboard est supprimé avec succés !');
    }

    public function update(Request $request, $id)
    {
    }
}
