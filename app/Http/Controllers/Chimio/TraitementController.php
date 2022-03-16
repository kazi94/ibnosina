<?php

namespace App\Http\Controllers\Chimio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelsChimio\Patient;
use App\ModelsChimio\Traitement;
use Illuminate\Support\Facades\Auth;
use App\ModelsChimio\Pathologies;
use App\ModelsChimio\Cure;
use App\ModelsChimio\Sequencetype;
use App\ModelsChimio\Sequence;
use App\ModelsChimio\Medicament_sequencetype;
use App\ModelsChimio\Prescription;
use App\ModelsChimio\Protocole;
use App\ModelsChimio\FormuleSC;

class TraitementController extends Controller
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
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
       //récupérer les données
       $patient = $request->input('patient_id');
       $maladie = $request->input('maladie_nom');
       $protocole = $request->input('protocole');
       $nature = $request->input('nature');
       $date_trait = $request->input('dater');
       $prevu = $request->input('prevu');
       $stade = $request->input('stade');
       $date_cure = $request->input('dateCure');
       $commentaire_cure = $request->input('commentaireCure');
       $localisation = strtoupper($request->input('localisation'));
       $taille = $request->input('taille');
       $poids = $request->input('poids');
       $surf = $request->input('surf');
       $checkfield = $request->input('checkfield');
       $commm = $request->input('commentaire');
       //get id maladie from nom maladie
       $id_maladie = Pathologies::where('pathologie',$maladie)->get(); 

       //add traitement
       $taritement = new Traitement();
       $taritement->date_debut_traitement = $date_trait;
       $taritement->nombre_cure_prevu = $prevu;
       $taritement->stade = $stade;
       $taritement->localisation = $localisation;
       $taritement->valide = 'en cours';
       if ($checkfield) {
           $taritement->commentaire = $commm;
       }
       $taritement->nature = $nature;
       $taritement->patient_id = $patient;
       $taritement->protocole_id = $protocole;
       $taritement->medecin_id = Auth::user()->id;
       $taritement->pathologies_id = $id_maladie[0]->id ;
       $taritement->save();

       //add cure avec etat='en cours'
       $cure = new Cure();
       $cure->numero =1;
       $cure->etat ='en cours';
       $cure->date_debut_cure = $date_cure;
       if ($checkfield) {
           $cure->commentaire  = $commentaire_cure;
       }
       $taritement->cures()->save($cure);

       //add sequence avec [confirmed = 0 , etat = prevue, date j1 = date c1]
       $sequence_type = Sequencetype::where('protocole_id', $protocole)->get();
       foreach ($sequence_type as $key =>$st){
        $sequence = new Sequence();
        $sequence->jour = $st->jour;
        $sequence->poids = $poids;
        $sequence->taille = $taille;
        $sequence->masse = $surf;
        $sequence->nature = $nature;
        $sequence->confirmed = 0;
        $sequence->protocole_id = $protocole;
        $sequence->etat = 'prevue';
        if ($key == 0) {
          $sequence->date_debut = $date_cure; 
        }else{
          $jj= $st->jour-1;
            $sequence->date_debut =date("Y-m-d", strtotime($date_cure."+".$jj."days")) ;
        }
        $cure->sequences()->save($sequence);


        //add medicament_sequences
        $medi_sequence_type = Medicament_sequencetype::where('sequencetype_id', $st->id)->get();
        foreach ($medi_sequence_type as $mst){
            $sequence->medicaments()->attach($mst->sp_id, ['posologie' => $mst->posologie,'voie' => $mst->voie, 
                'type' => $mst->type, 'etat' => 'prevue', 'solvant' => $mst->solvant , 'remarque' => $mst->commentaire ,'u1' => $mst->u1 ,'u2' => $mst->u2 ,'u3' => $mst->u3 ]);
        }
       }

       //add prescription
       $prescription = new Prescription();
       $sequence->prescriptiosChimio()->save($prescription);

       return redirect(route('patient.edit',$patient))->with('notif','Traitement ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $traitement = Traitement::find($id);
       dd($traitement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Traitement::destroy($id);
        return response()->json(['success'=>true]);
    }

    public function showAdd($id)
    {
        $erreur ='';
        $erreurformule ='';
        $patient = Patient::find($id);
    
        //tester si le patient a un traitement 'en cours'
        $traitement =Traitement::where('patient_id',$patient->id)->latest('id')->first();
        if ($traitement) {
            if ($traitement->valide == 'en cours') {
            $erreur = 'Le patient a deja un traitement en cours ';
          }
        }
        //récupérer formule de calcule sc
        $formule = FormuleSC::where('confirmed',1)->pluck('formule')->first();
        if (empty($formule)) {
           $erreurformule='pas de formule de calcule SC trouvé';         
        }        
        
        return view('chimio.traitement',compact('patient','erreur','erreurformule','formule'));  
        
    }

    public function countCure($id){
      $nbCure = Cure::where('traitement_id',$id)->count();
      return response()->json([$nbCure]);
    }

    function getDateCure($id){
      //récupérer la derniere cure
      $cure = Cure::where('traitement_id',$id)->get()->last();
      //récupérer date dernier séquence
      $sequence = Sequence::where('cure_id', $cure->id)->get()->last();
      //get intervalle cure from protocole + l'ajouter a la date
      $protocole = Protocole::where('id',$sequence->protocole_id)->first();

      $date = date("Y-m-d", strtotime($sequence->date_debut."+".$protocole->intervalle_cure."days")) ;
      //renvoi le résultat finale  
      return response()->json([$date]);
    }
    
    function addCure(Request $request){
       //récupérer les données
       $id_traitement = $request->input('idTraitement');
       $numeroo = $request->input('numeroCuree');
       $date = $request->input('datecure');
       $comm = $request->input('commmm');

       $taille = $request->input('taillecure');
       $poids = $request->input('poidscure');
       $masse = $request->input('massecuree');
    
       //get id protocole from id traitement
       $traitement = Traitement::find($id_traitement)->first();
       $protocole = Protocole::find($traitement->protocole_id)->first();

       //add cure avec etat='en cours'
       $cure = new Cure();
       $cure->numero = $numeroo;
       $cure->etat ='en cours';
       $cure->date_debut_cure = $date;
       $cure->commentaire  = $comm;
       $cure->traitement_id = $id_traitement;
       $cure->save();

      //add sequence avec [confirmed = 0 , etat = prevue, date j1 = date c1]
       $sequence_type = Sequencetype::where('protocole_id', $protocole->id)->get();
       foreach ($sequence_type as $key =>$st){
        $sequence = new Sequence();
        $sequence->jour = $st->jour;
        $sequence->poids = $poids;
        $sequence->taille = $taille;
        $sequence->masse = $masse;
        $sequence->nature = 'Classique';
        $sequence->confirmed = 0;
        $sequence->protocole_id = $protocole->id;
        $sequence->etat = 'prevue';
        if ($key == 0) {
          $sequence->date_debut = $date; 
        }else{
          $jj= $st->jour-1;
            $sequence->date_debut =date("Y-m-d", strtotime($date."+".$jj."days")) ;
        }
        $cure->sequences()->save($sequence); 
        //add medicament_sequences
        $medi_sequence_type = Medicament_sequencetype::where('sequencetype_id', $st->id)->get();
        foreach ($medi_sequence_type as $mst){
            $sequence->medicaments()->attach($mst->sp_id, ['posologie' => $mst->posologie, 'voie' => $mst->voie, 
                'type' =>$mst->type]);
        }
    }
          return redirect(route('patient.edit',$traitement->patient_id))->with('notif','Cure ajouté');
    }

    //arreter traitement
    function arrete(Request $request){
      $id = $request->id;
      $comm = $request->text;
      //update traitement
      $trait = Traitement::find($id);
      $trait->date_arrete = date('Y-m-d');
      $trait->valide = 'Arreter';
      $trait->comm_arrete = $comm;
      $trait->id_user_arrete = Auth::user()->id;
      $trait->save();
      //get all cure traitement
      $cures = Cure::where('traitement_id',$trait->id)->get();
      foreach ($cures as $cure) {
        //get all sequences cure
        $sequences = Sequence::where('cure_id', $cure->id)->get();
        foreach ($sequences as $sequence) {
          if ($sequence->etat =='prevue' || $sequence->etat =='prescrite' || $sequence->etat =='demande' || $sequence->etat =='disponse') {
            if ($sequence->date_arrete == null) {
              $sequence->date_arrete = date('Y-m-d');
              $sequence->comm_arrete = 'Traitement Arreter';
              $sequence->id_user_arrete = Auth::user()->id;
            }
            $sequence->etat ='Arreter';
            $sequence->save();
            foreach($sequence->medicaments()->get() as $dci){
              $dci->pivot->etat = 'Arreter';
              $dci->pivot->save();
            }
          }
        }
      }
      
      return response()->json(['success'=>true]);
     

    }
}
