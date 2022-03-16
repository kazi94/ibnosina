<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmaco;


use Storage;
use DB;
use Validator;
class pharmacoController extends Controller
{
    public function index()
    {
        return view ('admin.pharm.create');
    }

    public function liste1()
    {
       return view ('admin.pharm.liste1');
    }

    public function liste2()
    {
        return view ('admin.pharm.liste2');
    }
public function store(Request $request)
    {
        if ($request->isMethod('POST')) {    
           
              
               $p = new Pharmaco;

               
               $p->date_declaration_rapporteur = $request->date_declaration_rapporteur;
               $p->nom_pharmaco = $request->nom_pharmaco;
               $p->age_du_malade = $request->age_du_malade;
               $p->poids = $request->poids;
               $p->taille = $request->taille;
               $p->sexe = $request->sexe;
               $p->description_reaction = $request->description_reaction;
               $p->date_d_apparition = $request->date_d_apparition;
               $p->duree = $request->duree;

               $p->medicament1 = $request->medicament1;
               $p->n_lot1 = $request->n_lot1;
               $p->voie_admin1 = $request->voie_admin1;
               $p->posologie1 = $request->posologie1;
               $p->date_admin_debu1 = $request->date_admin_debu1;
               $p->d_admin_fin1 = $request->d_admin_fin1;
               $p->raison_d_emp1 = $request->raison_d_emp1;

               $p->medicament2 = $request->medicament2;
               $p->n_lot2 = $request->n_lot2;
               $p->voie_admin2 = $request->voie_admin2;
               $p->posologie2 = $request->posologie2;
               $p->date_admin_debu2 = $request->date_admin_debu2;
               $p->d_admin_fin2 = $request->d_admin_fin2;
               $p->raison_d_emp2 = $request->raison_d_emp2;

               $p->medicament3 = $request->medicament3;
               $p->n_lot3 = $request->n_lot3;
               $p->voie_admin3 = $request->voie_admin3;
               $p->posologie3 = $request->posologie3;
               $p->date_admin_debu3 = $request->date_admin_debu3;
               $p->d_admin_fin3 = $request->d_admin_fin3;
               $p->raison_d_emp3 = $request->raison_d_emp3;

               $p->medicament4 = $request->medicament4;
               $p->n_lot4 = $request->n_lot4;
               $p->voie_admin4 = $request->voie_admin4;
               $p->posologie4 = $request->posologie4;
               $p->date_admin_debu4 = $request->date_admin_debu4;
               $p->d_admin_fin4 = $request->d_admin_fin4;
               $p->raison_d_emp4 = $request->raison_d_emp4;

               $p->medicament5 = $request->medicament5;
               $p->n_lot5 = $request->n_lot5;
               $p->voie_admin5 = $request->voie_admin5;
               $p->posologie5 = $request->posologie5;
               $p->date_admin_debu5 = $request->date_admin_debu5;
               $p->d_admin_fin5 = $request->d_admin_fin5;
               $p->raison_d_emp5 = $request->raison_d_emp5;

               $p->medicament6 = $request->medicament6;
               $p->n_lot6 = $request->n_lot6;
               $p->voie_admin6 = $request->voie_admin6;
               $p->posologie6 = $request->posologie6;
               $p->date_admin_debu6 = $request->date_admin_debu6;
               $p->d_admin_fin6 = $request->d_admin_fin6;
               $p->raison_d_emp6 = $request->raison_d_emp6;

               
               $p->nature_traitement = $request->nature_traitement;
               $p->desc_traitement = $request->desc_traitement;
            
               
               
               $p->evolution =  $request->evolution;
             
            
               $p->sequelle = $request->sequelle;

               $p->histoire_maladie = $request->histoire_maladie;
               $p->facteurs_de_risque = $request->facteurs_de_risque;
               $p->nom = $request->nom;
               $p->prenom = $request->prenom;
               $p->tel = $request->tel;
               $p->adresse = $request->adresse;
               $p->email = $request->email;
               $p->type_d_exercice = $request->type_d_exercice;
               $p->adresse_postale = $request->adresse_postale;

               $p->envoye = 'non';
               
               $p->save();

              return redirect()->back()->with('message' , 'Votre réponse est enregistrée !');
 
 }
    }



    public function envoyee($pharmaco)
    {
        $p = Pharmaco::find($pharmaco);
        $p->envoye = 'oui';
            
            $p->save();
        
    
            return redirect()->back()->with('message' , 'Votre réponse est envoyée !');
    
    
    }
 /*public function show($id)
    {
        //
    }
*/
 public function edit($id)
    {
        $pharmaco = Pharmaco::find($id);

        return view('admin.pharm.edit',compact('pharmaco'));
   
    }

public function update(Request $request, $id)
    {
       
            $p = Pharmaco::find($id);
            $p->date_declaration_rapporteur = $request->date_declaration_rapporteur;
            $p->nom_pharmaco = $request->nom_pharmaco;
            $p->age_du_malade = $request->age_du_malade;
            $p->poids = $request->poids;
            $p->taille = $request->taille;
            if($request->sexee == 'f'){
                $p->sexe = 'f';
            }elseif($request->sexee == 'm'){
                $p->sexe = 'm';
            }
            else
                return'error';

            $p->description_reaction = $request->description_reaction;
            $p->date_d_apparition = $request->date_d_apparition;
            $p->duree = $request->duree;

            $p->medicament1 = $request->medicament1;
            $p->n_lot1 = $request->n_lot1;
            $p->voie_admin1 = $request->voie_admin1;
            $p->posologie1 = $request->posologie1;
            $p->date_admin_debu1 = $request->date_admin_debu1;
            $p->d_admin_fin1 = $request->d_admin_fin1;
            $p->raison_d_emp1 = $request->raison_d_emp1;

            $p->medicament2 = $request->medicament2;
            $p->n_lot2 = $request->n_lot2;
            $p->voie_admin2 = $request->voie_admin2;
            $p->posologie2 = $request->posologie2;
            $p->date_admin_debu2 = $request->date_admin_debu2;
            $p->d_admin_fin2 = $request->d_admin_fin2;
            $p->raison_d_emp2 = $request->raison_d_emp2;

            $p->medicament3 = $request->medicament3;
            $p->n_lot3 = $request->n_lot3;
            $p->voie_admin3 = $request->voie_admin3;
            $p->posologie3 = $request->posologie3;
            $p->date_admin_debu3 = $request->date_admin_debu3;
            $p->d_admin_fin3 = $request->d_admin_fin3;
            $p->raison_d_emp3 = $request->raison_d_emp3;

            $p->medicament4 = $request->medicament4;
            $p->n_lot4 = $request->n_lot4;
            $p->voie_admin4 = $request->voie_admin4;
            $p->posologie4 = $request->posologie4;
            $p->date_admin_debu4 = $request->date_admin_debu4;
            $p->d_admin_fin4 = $request->d_admin_fin4;
            $p->raison_d_emp4 = $request->raison_d_emp4;

            $p->medicament5 = $request->medicament5;
            $p->n_lot5 = $request->n_lot5;
            $p->voie_admin5 = $request->voie_admin5;
            $p->posologie5 = $request->posologie5;
            $p->date_admin_debu5 = $request->date_admin_debu5;
            $p->d_admin_fin5 = $request->d_admin_fin5;
            $p->raison_d_emp5 = $request->raison_d_emp5;

            $p->medicament6 = $request->medicament6;
            $p->n_lot6 = $request->n_lot6;
            $p->voie_admin6 = $request->voie_admin6;
            $p->posologie6 = $request->posologie6;
            $p->date_admin_debu6 = $request->date_admin_debu6;
            $p->d_admin_fin6 = $request->d_admin_fin6;
            $p->raison_d_emp6 = $request->raison_d_emp6;

            
            $p->nature_traitement = $request->nature_traitement;

            if($request->nature_traitementt == 'medic'){
                $p->nature_traitement = 'medic';

            }elseif($request->nature_traitementt == 'non_medic'){
                $p->nature_traitement = 'non_medic';
            }
            else
                return'error';



            $p->desc_traitement = $request->desc_traitement;
         
            if($request->evolutionn == 'disparition'){
                $p->evolution = 'disparition';
            }elseif($request->evolutionn == 'en_cours'){
                $p->evolution = 'en_cours';
            }
            elseif($request->evolutionn == 'inconnue'){
                $p->evolution = 'inconnue';

            }elseif($request->evolutionn == 'deces'){
                $p->evolution = 'deces';

            }
        
              else  return'error';

            if($request->sequellee == 'oui'){
                $p->sequelle = 'oui';

            }elseif($request->sequellee == 'non'){
                $p->sequelle = 'non';
            }
            else
                return'error';

            $p->histoire_maladie = $request->histoire_maladie;
            $p->facteurs_de_risque = $request->facteurs_de_risque;
            $p->nom = $request->nom;
            $p->prenom = $request->prenom;
            $p->tel = $request->tel;
            $p->adresse = $request->adresse;
            $p->email = $request->email;
            $p->type_d_exercice = $request->type_d_exercice;
            $p->adresse_postale = $request->adresse_postale;

            
            $p->save();
                   
           return redirect()->back()->with('message' , 'Votre réponse est modifiée !');
    }


    public function show($id){

        $pharmaco = Pharmaco::find($id);

        return view('admin.pharm.detail',compact('pharmaco'));
    }


    public function destroy($id)
    {
        //fetch row to delete
        Pharmaco::where('id',$id)->delete();

        return redirect()->back()->with('message' , 'Regle supprimée avec succés !');
    }
}

