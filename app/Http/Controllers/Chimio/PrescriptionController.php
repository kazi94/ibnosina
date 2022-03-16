<?php

namespace App\Http\Controllers\Chimio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelsChimio\Sequence;
use App\ModelsChimio\Traitement;
use App\ModelsChimio\Cure;
use App\ModelsChimio\Patient;
use App\ModelsChimio\Prescription;
use Illuminate\Support\Facades\Auth;
use App\ModelsChimio\FormuleSC;
use App\ModelsChimio\unite;

class PrescriptionController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //récupérer formule de calcule sc
        $formule = FormuleSC::where('confirmed',1)->pluck('formule')->first();
        //récupérer la sequence
        $sequence = Sequence::where('id',$id)->first();
        //récupérer la cure de la séquence 
        $cure = Cure::where('id',$sequence->cure_id)->first();
        //récupérer le traitement de la séquence 
        $traitement = Traitement::where('id',$cure->traitement_id)->first();
        //récupérer les Dci de la séquence
        $ligne_dci = $sequence->medicaments()->get();
        //dd($ligne_dci);
        $ligne_dci_prem = collect();
        $ligne_dci_trait = collect();
        foreach ($ligne_dci  as $l) {
            if ($l->pivot->type =='prem') {
                $ligne_dci_prem->put($l->SP_CODE_SQ_PK,$l);
            }
            else
                 $ligne_dci_trait->put($l->SP_CODE_SQ_PK,$l);
        }
        //récupérer le patient 
        $patient = Patient::where('id',$traitement->patient_id)->first();

        $unites = unite::all();


        return view('chimio.prescription',compact('formule', 'sequence' ,'cure','traitement','patient','ligne_dci_prem','ligne_dci_trait','unites')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $id = $request->input('id');

        $date_presc = $request->input('datePresc');
        $date_presc_hid = $request->input('datePreschidden');

        $taille = $request->input('taille');
        $poids = $request->input('poids');
        $surf = $request->input('surf');

        $nature = $request->input('nature');

        $confirmer = $request->input('confirmer');
        if ($confirmer == 0) {
            return 'confirmer';
        }

        $medic_prem = $request->input('med_sp_id_prem');
        $medic_trait = $request->input('med_sp_id_trait');
        if ($medic_prem == null && $medic_trait == null) {
            return 'rien';
        }

        $voie_prem = $request->input('voie_prem');
        $voie_trait = $request->input('voie_trait');

        $pos_prem = $request->input('pos_prem');
        $pos_trait = $request->input('pos_trait');

        $u1_trait = $request->input('u1_trait');
        $u2_trait = $request->input('u2_trait');
        $u3_trait = $request->input('u3_trait');

        $u1_prem = $request->input('u1_prem');
        $u2_prem = $request->input('u2_prem');

        $dose_prem = $request->input('dose_prem');
        $dose_trait = $request->input('dose_trait');

        $red_trait = $request->input('red_trait');
        
        $time_prem = $request->input('time_prem');
        $time_trait = $request->input('time_trait');

        $solvant_prem = $request->input('solvant_prem');
        $solvant_trait = $request->input('solvant_trait');
        $commentairedci_prem = $request->input('commentairedci_prem');
        $commentairedci_trait = $request->input('commentairedci_trait');

        $commentaireMed = $request->input('commentaireMed');
        $commentairePharma = $request->input('commentairePharma');

        $etat = $request->input('etat');

        //update sequence 
        $seq = Sequence::find($id);
        $seq->poids = $poids;
        $seq->taille = $taille;
        $seq->masse = $surf;
        $seq->nature = $nature;
        $seq->confirmed = 1;
        $seq->etat = $etat;
        $seq->save();


        //update pivot table
         $seq->medicaments()->detach();
        //prem
            if ($medic_prem != null) {
                 for ($p=0; $p < sizeof($medic_prem); $p++) { 
                    $seq->medicaments()->attach($medic_prem[$p], ['posologie' => $pos_prem[$p], 'voie' => $voie_prem[$p], 
                        'type' =>'prem','etat' => $etat , 'heure' => $time_prem[$p], 'date_debut' => $date_presc, 'dose_calcule' => $dose_prem[$p], 'solvant' => $solvant_prem[$p], 'remarque' => $commentairedci_prem[$p],'u1' => $u1_prem[$p] ,'u2' => $u2_prem[$p] ]);
                }     
            }
        //trait
            if ($medic_trait != null) {
                for ($t=0; $t < sizeof($medic_trait); $t++) { 
                $seq->medicaments()->attach($medic_trait[$t], ['posologie' => $pos_trait[$t], 'voie' => $voie_trait[$t], 
                    'type' =>'trait','reduction' => $red_trait[$t] ,'heure' => $time_trait[$t], 'date_debut' => $date_presc , 'etat' => $etat , 'dose_calcule' => $dose_trait[$t], 'solvant' => $solvant_trait[$t], 'remarque' => $commentairedci_trait[$t],'u1' => $u1_trait[$t],'u2' => $u2_trait[$t],'u3' => $u3_trait[$t]]);
                
                }
            }


        //insert table prescription
        if ($etat == 'prevue' || $request->input('etatt') == 1) {
            $ligne = Prescription::where('sequence_id',$id)->first();
            Prescription::destroy($ligne->id);
            //return response()->json(['success'=>true]);
        } 
        if ($etat == 'prescrite' || $etat == 'demande') {
            $prescription = new Prescription();
            $prescription->medecin_id = Auth::user()->id;
            $prescription->med_validate_at = date('Y-m-d');
            $prescription->commentaireMed = $commentaireMed;
            $seq->prescriptiosChimio()->save($prescription);
        }

        return response()->json(['success'=>true]);
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
        //test si c'est la derniere prescription -> on supp aussi la cure
        $sequence = Sequence::where('id',$id)->first();
        $count = Sequence::where('cure_id',$sequence->cure_id)->count();
        if ($count == 1) {
           Cure::destroy($sequence->cure_id); 
        }else{
            Sequence::destroy($id);  
        }    
        return response()->json(['success'=>true]);
    }

    public function arreter(Request $request)
    {
        $id = $request->id;
        $comm = $request->text;
        //delete validation id med arrete prescription
        $seq = Sequence::find($id);
        if ($seq->etat == 'demande' || $seq->etat == 'prescrite') {
            $ligne = Prescription::where('sequence_id',$seq->id)->first();
            Prescription::destroy($ligne->id);
        }
        //update sequences
        $seq->date_arrete = date('Y-m-d');
        $seq->etat = 'Arreter';
        $seq->comm_arrete = $comm;
        $seq->id_user_arrete = Auth::user()->id;
        $seq->save();
        //change etat all dci de sequence
        foreach($seq->medicaments()->get() as $dci){
              $dci->pivot->etat = 'Arreter';
              $dci->pivot->save();
            }
        return response()->json(['success'=>true]);
    }

    function dis(Request $request){
      $id = $request->id;
      $comm = $request->commm;

      //update sequence
      $seq = Sequence::find($id);
      $seq->etat = 'Dispenser';
      $seq->save();

      //update table pivot 
      foreach($seq->medicaments()->get() as $dci){
              $dci->pivot->etat = 'Dispenser';
              $dci->pivot->save();
      }

      //update prescription validation pharma
      $pre = Prescription::where('sequence_id',$id)->first();
      $pre->commentairePha = $comm;
      $pre->pharmacien_id = Auth::user()->id;
      $pre->phar_validate_at = date('Y-m-d');
      $pre->save();

      return response()->json(['success'=>true]);
    }

    function encours(Request $request){
      $id = $request->id;
      $comm = $request->commm;
      //update sequence
      $seq = Sequence::find($id);
      $seq->etat = 'en cours de prep';
      $seq->save();

      //update table pivot 
      foreach($seq->medicaments()->get() as $dci){
              $dci->pivot->etat = 'en cours de prep';
              $dci->pivot->save();
      }

      //update prescription validation pharma
      $pre = Prescription::where('sequence_id',$id)->first();
      $pre->commentairePha = $comm;
      $pre->pharmacien_id = Auth::user()->id;
      $pre->phar_validate_at = date('Y-m-d');
      $pre->save();

      return response()->json(['success'=>true]);

    }
}
