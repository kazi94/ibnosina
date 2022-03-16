<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTraitement;
use App\Models\Ligneprescription;
use App\Models\Traitementchronique;
use DB;
use Validator;
use Auth;

class TraitementchroniqueController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTraitement $request)
  {
    if (Auth::user()->cant('traitements_chronique.create'))
      return redirect()->back()->with('message', 'Action non autorisée !');

    $trait_id = $this->storeTraitement($request);

    session(['tab' => 'tab_4']);

    return response()->json("success", 201);

    //  return redirect()->back()->with(['message' => 'Médicament(s) ajouté(s) avec succés !', 'tab' => 'tab_4']);      
  }

  public function storeTraitement($data)
  {
    $id = array();
    $tmp = null;

    if ($data->user()->id != '1' && $data->user()->role->analyse_ph == "on")  // soit 'on' ou 'null'
      $tmp = 1;
    $meds = json_decode($data->med_sp_id, true);

    for ($i = 0; $i < count($meds); $i++) {

      $id[$i] = DB::table('traitementchroniques')->insertGetId(
        [
          'patient_id' => $data->patient_id,
          'created_by' => $data->user()->id,
          'created_at' => now(),

        ]
      );

      // if ($data->type_j == "mois")  $nbr_jour = 31*$data->nbr_jours[$i];
      //   else if ($data->type_j == "semaines")  $nbr_jour = 7*$data->nbr_jours[$i];
      //     else $nbr_jour = $data->nbr_jours[$i];

      $ligne = new Ligneprescription;
      $ligne->medecin_externe = $data->medecin_externe;
      $ligne->etats = "En cours";
      $ligne->date_etats = $meds[$i]['date_etats'];
      $ligne->status_hopital = $meds[$i]['status_hopital'];
      $ligne->dose = $meds[$i]['dose'];
      $ligne->dose_matin = $meds[$i]['dose_matin'];
      // $ligne->repas_matin = $meds[$i]['repas_matin'];
      $ligne->dose_midi = $meds[$i]['dose_midi'];
      // $ligne->repas_midi = $meds[$i]['repas_midi'];
      $ligne->dose_soir = $meds[$i]['dose_soir'];
      // $ligne->repas_soir = $meds[$i]['repas_soir'];
      // $ligne->tmp = $tmp;
      $ligne->dose_avant_coucher = $meds[$i]['dose_avant_coucher'];
      $ligne->unite = $meds[$i]['unite'];
      $ligne->voie = ((isset($meds[$i]['voie'])) ? $meds[$i]['voie'] : "");
      $ligne->traitementchronique_id = $id[$i];
      $ligne->med_sp_id = $meds[$i]['med_sp_id'];
      $ligne->save();
    }
    return $id;
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
    if (Auth::user()->cant('traitements_chronique.update'))
      return redirect()->back()->with('message', 'Action non autorisée !');



    $ligne                          = Ligneprescription::find($id);
    $ligne->medecin_externe         = $request->medecin_externe;
    $ligne->date_etats              = $request->date_etats;
    $ligne->status_hopital          = $request->status_hopital;
    $ligne->dose_matin              = $request->dose_matin;
    $ligne->repas_matin             = $request->repas_matin;
    $ligne->dose_midi               = $request->dose_midi;
    $ligne->repas_midi              = $request->repas_midi;
    $ligne->dose_soir               = $request->dose_soir;
    $ligne->repas_soir              = $request->repas_soir;
    $ligne->dose_avant_coucher      = $request->dose_avant_coucher;
    $ligne->save();

    return redirect()->back()->with(['message' => 'Médicament Modifié !', 'tab' => 'tab_4']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $deleted = Traitementchronique::where('id', $id)->delete();
    // reset auto increment to the last id before deleted
    DB::update("ALTER TABLE traitementchroniques AUTO_INCREMENT = 1;");
    DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
    return  response()->json(['response' => 'success', 'msg' => 'Médicament supprimé avec succés !'], 200);
  }
  /**
   * delete tmp traitement
   *
   * @return void
   * @author 
   **/
  public function destroy_tmp($id)
  {
    //fetch row to delete
    $deleted = Ligneprescription::where('id', $id)->delete();
    // reset auto increment to the last id before deleted
    DB::update("ALTER TABLE ligneprescriptions AUTO_INCREMENT = 1;");
    return $deleted ?  response()->json(['response' => 'success', 'msg' => 'Médicament supprimé avec succés !'], 200) : 'Erreur dans la suppression';
  }
  /**
   * valide medicament by doctor
   *
   * @return void
   * @author 
   **/
  public function confirm($id)
  {
    //fetch row to set tmp to NUL
    $ligne      = Ligneprescription::find($id);
    $ligne->tmp = NULL;
    $ligne->save();

    return response()->json(['response' => 'success', 'msg' => 'Médicament Validé avec succés !'], 200);
  }
  /**
   * get historique du traitement chronique et la ligne prescription
   *
   * @return void
   * @author 
   **/
  public function getHisTraitement()
  {
    $line = Ligneprescription::find($_POST['ligne_id']);

    return response()->json($line, 201);
  }


  /**
   * return the last state of the traitement chronique
   *
   *
   * @param Type $id 
   * @return LignePrescription
   **/
  public function getLastState($id)
  {

    $line = Ligneprescription::find($id);

    $trait_id = $line->traitementchronique_id;

    $history = DB::table('traitementchroniques')
      ->join('ligneprescriptions', 'traitementchroniques.id', 'ligneprescriptions.traitementchronique_id')
      ->where('traitementchroniques.id', $trait_id)
      ->orderBy('ligneprescriptions.date_etats', 'desc')
      ->get();
    return response()->json([
      'line' => $line,
      'history' => $history
    ], 201);
  }

  /**
   * udpate state
   * @param Request  $var Description
   **/
  public function updateState(Request $req, $id)
  {
    // $this->validate($request, [
    //   'date_etats'  => 'required|date|before:tomorrow|after:' . $request->old_date,
    // ]);
    $ligne = Ligneprescription::find($id);

    $newLine = new LignePrescription;
    $newLine->date_etats = $req->date_etats;
    $newLine->etats = $req->etats;
    $newLine->medecin_externe         = $ligne->medecin_externe;
    $newLine->status_hopital          = $ligne->status_hopital;
    $newLine->dose_matin              = $ligne->dose_matin;
    $newLine->repas_matin             = $ligne->repas_matin;
    $newLine->dose_midi               = $ligne->dose_midi;
    $newLine->repas_midi              = $ligne->repas_midi;
    $newLine->dose_soir               = $ligne->dose_soir;
    $newLine->repas_soir              = $ligne->repas_soir;
    $newLine->dose_avant_coucher      = $ligne->dose_avant_coucher;
    $newLine->traitementchronique_id      = $ligne->traitementchronique_id;
    $newLine->unite = $ligne->unite;
    $newLine->voie = $ligne->voie;
    $newLine->med_sp_id = $ligne->med_sp_id;
    $newLine->save();

    // $traitement = Traitementchronique::find($ligne->traitementchronique_id);
    // $traitement->updated_by = $request->user()->id;
    // $traitement->updated_at = now();
    // $traitement->save();    

    return redirect()->back()->with(['message' => 'Mise à jour effectuée!', 'tab' => 'tab_4']);
  }
}
