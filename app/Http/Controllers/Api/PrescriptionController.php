<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prescription;
use DB;

class PrescriptionController extends Controller
{
    /**
     * Get detail of prescription
     *
     * @param  $id prescription ID
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Prescription
     */
    public function fetchLinesById($id)
    {
        $presc = \App\Repositories\User\Prescriptions::getLinesById($id);

        $results = $presc->lignes->map(function ($val) {
            $medic = '';
            $resultats = DB::table('cosac_compo_subact')
                ->join(
                    'sac_subactive as t0',
                    't0.SAC_CODE_SQ_PK',
                    'cosac_compo_subact.cosac_sac_code_fk_pk'
                )
                ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                ->where(
                    'cosac_compo_subact.cosac_sp_code_fk_pk',
                    $val->med_sp_id
                )
                ->get();

            foreach ($resultats as $key => $resultat) {
                $medic .= $resultat->sac_nom . " " . $resultat->cosac_dosage
                    . $resultat->cosac_unitedosage . (($key ==
                        (count($resultats) - 1)) ? '.' : '/');
            }
            $val['medicament_dci'] = $medic;
            return $val;
        });
        return response()->json($results, 200);
    }
}
