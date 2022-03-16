<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Ligneprescription;
use App\Models\Automedication;
use DB;

class MedicamentController extends Controller
{
  public function show($id)
  {
    return view('admin.voie.show');
  }
  /**
   * Afficher tout les médicament produits en algérie qui n'ont pas de voie d'administration 
   *
   * @return Médicaments
   * @author 
   **/
  public function index()
  {
    $results = DB::select("SELECT `sp_nom`, `sp_code_sq_pk`
        FROM `sp_specialite`
        WHERE `sp_specialite`.`sp_code_sq_pk` NOT IN (
        SELECT `v`.`spvo_sp_code_fk_pk`
        FROM `spvo_specialite_voie` as v , sp_specialite as p
        where p.SP_CODE_SQ_PK=v.SPVO_SP_CODE_FK_PK) AND `SP_ALGERIE` = '1'
        limit 300
        ");
    $voies = DB::table('voies')->orderBy('cdf_nom', 'asc')->get();

    return view('admin.voie.show', compact('results', 'voies'));
  }


  /**
   * undocumented function
   *
   * @return void
   * @author 
   **/
  public function store(Request $request)
  {
    foreach ($request->voies_id as $key => $value) {
      foreach ($value as $val) {
        // echo $key." : ".$val."</br>";
        DB::table('spvo_specialite_voie')
          ->insert([
            'spvo_specialite_voie.spvo_cdf_vo_code_fk_pk' => $val,
            'spvo_specialite_voie.spvo_sp_code_fk_pk'    => $key
          ]);
      }
    }
  }

  /**
   * Retourne la liste des médicaments tapé dans la barre de recherche des médicaments
   *
   * @return Medicaments
   * @author Kazi Aoue Sid Ahmed
   */
  public function getMedicament()
  {
    $sps = DB::table('sp_specialite')
      ->where('sp_specialite.sp_nom', 'LIKE', '%' . $_POST['phrase'] . '%')
      ->select(
        DB::raw('sp_code_sq_pk as sp_id'),
        DB::raw(" sp_nom as medicament  "),
        DB::raw(" 'médicament' as status "),
        'sp_algerie'
      )
      ->limit(5)
      ->get();

    $sacs = DB::table('sac_subactive')
      ->join('cosac_compo_subact', 'sac_subactive.sac_code_sq_pk', 'cosac_compo_subact.cosac_sac_code_fk_pk')
      ->where('sac_subactive.sac_nom', 'like', '%' . $_POST['phrase'] . '%')
      ->groupBy('cosac_compo_subact.COSAC_SP_CODE_FK_PK')
      ->select(
        DB::raw("CONCAT(sac_subactive.SAC_NOM , ' ',cosac_compo_subact.COSAC_DOSAGE, ' ', cosac_compo_subact.COSAC_UNITEDOSAGE) AS medicament"),
        DB::raw(" 'substance active' as status "),
        DB::raw('cosac_compo_subact.COSAC_SP_CODE_FK_PK as sp_id')
      )
      ->limit(5)
      ->get();

    $results =  $sps->merge($sacs);
    $results = collect($results)->map(function ($result) {

      $result->unite = $this->getUnite($result->sp_id);
      $result->voies = $this->getVoies($result->sp_id);
      return $result;
    });

    return response()->json($results, 200);
  }

  protected function getUnite($sp_id)
  {
    $unite = DB::table('unites')
      ->join('pre_presentation', 'unites.id', 'pre_presentation.pre_cdf_up_code_fk')
      ->where('pre_presentation.pre_sp_code_fk', $sp_id)
      ->select('unites.unite_nom')
      ->distinct()
      ->get();
    return $unite ? $unite : [];
  }

  protected function getVoies($sp_id)
  {
    $voies = DB::table('voies')
      ->join('spvo_specialite_voie', 'spvo_specialite_voie.spvo_cdf_vo_code_fk_pk', 'voies.cdf_code_pk')
      ->where('spvo_specialite_voie.spvo_sp_code_fk_pk', $sp_id)
      ->select('voies.cdf_nom')
      ->distinct()
      ->get();
    return $voies ? $voies : [];
  }


  public function getMedicamentSpUnit()
  { //fonction qui retourne les unités et les voies d'administrations

    $spec_id = $_POST['spec_id'];

    $unites = DB::table('unites')
      ->join('pre_presentation', 'unites.id', 'pre_presentation.pre_cdf_up_code_fk')
      ->where('pre_presentation.pre_sp_code_fk', $spec_id)
      ->select('unites.unite_nom')
      ->distinct()
      ->get();

    $voies = DB::table('voies')
      ->join('spvo_specialite_voie', 'spvo_specialite_voie.spvo_cdf_vo_code_fk_pk', 'voies.cdf_code_pk')
      ->where('spvo_specialite_voie.spvo_sp_code_fk_pk', $spec_id)
      ->select('voies.cdf_nom')
      ->distinct()
      ->get();

    return response()->json([$unites, $voies]);
  }

  public function getMedicamentDci()
  {
    $result = "";
    $unites = "";
    if (isset($_POST['spec_id'])) {
      $spec_id = $_POST['spec_id'];
      $result = DB::table('sac_subactive')
        ->join('cosac_compo_subact', function ($join) {
          $join->on('sac_subactive.sac_code_sq_pk', '=', 'cosac_compo_subact.cosac_sac_code_fk_pk');
        })
        ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $spec_id)
        ->select('sac_subactive.sac_nom', 'sac_subactive.sac_code_sq_pk', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
        ->get();

      return response()->json($result);
    } else if (isset($_POST['phrase_dci'])) {
      $result = DB::table('sac_subactive')
        ->select('sac_nom', 'sac_code_sq_pk')
        ->distinct()
        ->where('sac_subactive.sac_nom', 'LIKE', '%' . $_POST['phrase_dci'] . '%')
        ->limit(10)
        ->get();
    }
    return response()->json($result);
  }

  /**
   * Fonction qui retourne les classes pharmacotherapeutique
   *
   * @return classe pharmacotherapeutique
   * @author Salafi_White_developper01
   **/
  public function get_classe()
  {

    $result = DB::table('cph_classepharmther')
      ->select('cph_code_pk', 'cph_nom')
      ->where("cph_nom", 'LIKE', '%' . $_POST['phrase_classe'] . '%')
      ->distinct()
      ->get();

    return response()->json($result);
  }
}
