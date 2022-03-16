<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Role::all()->where('id', '<>', '1');

        return view('admin.profile.show', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom_profile' => 'required|string|max:60|unique:roles',
        ]);

        $role = new Role();

        $tableau = array('patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'phyto', 'question', 'et', 'consultation', 'fiche', 'ho', 'act', 'dashboard', 'cpt_pat', 'cpt_ext', 'Prescription_chimio', 'Protocole_chimio', 'Cure_chimio');
        $tableau1 = array('Patient', 'Prescription', 'Automédication', 'Analyse_biologique', 'Traitement_chronique', 'Phytothérapie', 'Questionnaire', 'Education_thérapeutique', 'Consultation', 'Fiche_de_conciliation', 'Hospitalisation', 'acte_medicale', 'dashboard', 'compte_patient', 'compte_externe', 'Prescription_chimio', 'Protocole_chimio', 'Cure_chimio');


        $role->nom_profile         = $request->nom_profile;
        $role->analyse_ph          = $request->analyse_ph;
        $role->afficher_rdv        = $request->afficher_rdv;
        $role->analyse_th          = $request->analyse_th;   // voir le résultat de l'analyse thérapeutique
        $role->analyse_sv          = $request->analyse_sv;  // voir le résultat de l'analyse de suivie
        $role->editeur_regle       = $request->editeur_regle;  // accéder a l'éditeur de regle
        $role->medecin_presc       = $request->medecin_presc;
        $role->cloner_prescription = $request->cloner_Prescription;
        $role->ok_chimio           = $request->ok_chimio;
        $role->verif_medic         = $request->verif_medic;
        $role->dessiner_graphe     = $request->dessiner_graphe;
        $role->executer_demande_examen     = $request->executer_demande_examen;
        $role->administrer     = $request->administrer;



        for ($i = 0; $i < count($tableau); $i++) {
            //définir les noms des colonnes
            $x = 'lister_' . $tableau[$i];
            $y = 'ajouter_' . $tableau[$i];
            $z = 'modifier_' . $tableau[$i];
            $w = 'supprimer_' . $tableau[$i];
            $a = 'imprimer_' . $tableau[$i];
            $b = 'lister_details_' . $tableau[$i];
            $e = 'exporter_' . $tableau[$i];

            $x1 = 'lister_' . $tableau1[$i];
            $z1 = 'modifier_' . $tableau1[$i];
            $w1 = 'supprimer_' . $tableau1[$i];
            $a1 = 'imprimer_' . $tableau1[$i];
            $y1 = 'ajouter_' . $tableau1[$i];
            $b1 = 'détails_' . $tableau1[$i];
            $e1 = 'exporter_' . $tableau1[$i];

            $role->$x = $request->$x1;
            $role->$y = $request->$y1;
            $role->$z = $request->$z1;
            $role->$w = $request->$w1;
            $role->$a = $request->$a1;
            $role->$b = $request->$b1;
            $role->$e = $request->$e1;
        }

        $role->save(); // persist fields in the table 'roles'

        return redirect(route('profile.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.profile.edit', compact('role'));
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

        //validate resquest before store in DB
        $this->validate($request, [
            'nom_profile' => 'required|string|max:60',
            'permission[]' => 'digits:10'
        ]);

        $role = Role::find($id); // fetch row from id

        $tableau = array('patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'question', 'phyto', 'et', 'consultation', 'fiche', 'ho', 'act', 'dashboard', 'cpt_pat', 'cpt_ext', 'Prescription_chimio', 'Protocole_chimio');
        $tableau1 = array('Patient', 'Prescription', 'Automédication', 'Analyse_biologique', 'Traitement_chronique', 'Phytothérapie', 'Questionnaire', 'Education_thérapeutique', 'Consultation', 'Fiche_de_conciliation', 'Hospitalisation', 'acte_medicale', 'dashboard', 'compte_patient', 'compte_externe', 'Prescription_chimio', 'Protocole_chimio');

        $role->nom_profile         = $request->nom_profile;
        $role->analyse_ph          = $request->analyse_ph;
        $role->afficher_rdv        = $request->afficher_rdv;
        $role->analyse_th          = $request->analyse_th;   // voir le résultat de l'analyse thérapeutique
        $role->analyse_sv          = $request->analyse_sv;  // voir le résultat de l'analyse de suivie
        $role->editeur_regle       = $request->editeur_regle;  // accéder a l'éditeur de regle
        $role->medecin_presc       = $request->medecin_presc;
        $role->cloner_prescription = $request->cloner_Prescription;
        $role->ok_chimio           = $request->ok_chimio;
        $role->verif_medic         = $request->verif_medic;
        $role->dessiner_graphe     = $request->dessiner_graphe;
        $role->administrer     = $request->administrer;

        for ($i = 0; $i < count($tableau); $i++) {
            //définir les noms des colonnes
            $x = 'lister_' . $tableau[$i];
            $y = 'ajouter_' . $tableau[$i];
            $z = 'modifier_' . $tableau[$i];
            $w = 'supprimer_' . $tableau[$i];
            $a = 'imprimer_' . $tableau[$i];
            $b = 'lister_details_' . $tableau[$i];
            $e = 'exporter_' . $tableau[$i];

            $x1 = 'lister_' . $tableau[$i];
            $z1 = 'modifier_' . $tableau[$i];
            $w1 = 'supprimer_' . $tableau[$i];
            $a1 = 'imprimer_' . $tableau[$i];
            $y1 = 'ajouter_' . $tableau[$i];
            $b1 = 'détails_' . $tableau[$i];
            $e1 = 'exporter_' . $tableau[$i];

            $role->$x = $request->$x1;
            $role->$y = $request->$y1;
            $role->$z = $request->$z1;
            $role->$w = $request->$w1;
            $role->$a = $request->$a1;
            $role->$b = $request->$b1;
            $role->$e = $request->$e1;
        }

        $role->save(); // persist fields in the table 'roles'

        return redirect(route('profile.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();

        return redirect()->back();
    }
}
