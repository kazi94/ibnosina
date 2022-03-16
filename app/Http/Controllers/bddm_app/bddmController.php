<?php

namespace App\Http\Controllers\bddm_app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Whoops\Handler\PrettyPageHandler;
use Illuminate\Support\Facades\Log;
use Debugbar;
use Cache;

/**
 * summary
 */
class bddmController extends Controller
{
    /**
     * summary
     */
    public function __construct()
    {
        $handler = new PrettyPageHandler;
        $handler->setEditor('sublime');
    }

    /**
     * get searchBar View
     *
     * @return View
     * @author kaziSidou
     */
    public function search()
    {

        return view('bddm.home');
    }
    /**
     * return search medicament from search-bar
     *
     * @return medicament
     * @author Kazi Aouel Sid Ahmed
     */
    public function searchMedicament($phrase, $type_search)
    {

        switch ($type_search) {
            case 'meds':
                $result = DB::table('sp_specialite')
                    ->select(DB::raw("SP_CODE_SQ_PK as code"), DB::raw("SP_NOM as nom"), DB::raw(" 'meds' as type"), DB::raw(" SP_ALGERIE as alg"))
                    ->where('SP_NOM', 'like', '%' . $phrase . '%')
                    ->where('SP_COPIE', NULL)
                    ->get();
                break;
            case 'sac':
                $result = DB::table('sac_subactive')
                    ->orderBy('sac_nom', 'asc')
                    ->select(DB::raw("SAC_CODE_SQ_PK as code"), DB::raw("sac_nom as nom"), DB::raw(" 'sac' as type"))
                    ->where('sac_nom', 'like', '%' . $phrase . '%')
                    ->get();
                break;
            case 'atc':
                $result = DB::table('catc_classeatc')
                    ->select('CATC_CODE_PK', 'CATC_CATC_CODE_FK', 'CATC_NOMF')
                    ->where('CATC_CATC_CODE_FK',  null)
                    ->where('CATC_CODE_PK', '!=', 'x')
                    ->where('CATC_CODE_PK', '!=', 'z')
                    ->get();
                break;
            default:
                // code...
                break;
        }
        return response()->json($result);
        // ->header('Access-Control-Allow-Origin', '*')
        //->header('Access-Control-Allow-Methods', 'GET')
        // ->header('Access-Control-Allow-Credentials', 'true')
        // ->header('Access-Control-Allow-Methods','GET, POST, OPTIONS')
        // ->header('Access-Control-Allow-Headers','Origin, Content-Type, Accept');
        // ->header('Access-Control-Allow-Headers','application/json');
    }
    /**
     * Show Summary of specialite drugs
     *
     * @return Medicaments
     * @author Kazzi-White-SlafDeb---Web
     */
    public function showMedicaments()
    {
        $seconds = 604800; // One week
        $r = Cache::remember('meds', $seconds, function () {
            return DB::table('sp_specialite')
                ->select(DB::raw("distinct (SP_NOM) as SP_NOM"), 'SP_CODE_SQ_PK')
                ->where('SP_COPIE', NULL)
                ->orderBy('SP_NOM', 'asc')
                ->get();
        });
        return view('bddm.meds.meds_sp', compact('r'));
    }

    /**
     * show alphabet medicaments
     *
     * @return void
     * @author 
     */
    public function showAlphabetMedicaments($name)
    {
        // Sql queries
        $results = DB::table('sp_specialite')
            ->select(DB::raw("distinct (SP_NOM) as SP_NOM"), 'SP_CODE_SQ_PK')
            ->where('SP_COPIE', NULL)
            ->where('SP_NOM', 'like', $name . '%')
            ->orderBy('SP_NOM', 'asc')
            ->get();

        if (count($results) == 0) {
            return response()->json(['message' => "Aucuné médicament trouvé !"], 500);
        } else
            return response()->json(['data' => $results], 200);
    }

    /**
     * show list of medicaments to table
     *
     * @return void
     * @author 
     */
    public function showMedicamentsAjax()
    {

        $seconds = 604800; // One week
        $results = Cache::remember('ajax', $seconds, function () {
            return DB::table('sp_specialite')
                ->select(DB::raw("distinct (SP_NOM) as SP_NOM"), 'SP_CODE_SQ_PK')
                ->where('SP_COPIE', NULL)
                ->orderBy('SP_NOM', 'asc')
                ->get();
        });
        if (count($results) == 0) {
            return response()->json(['message' => "Aucuné médicament trouvé !"], 500);
        } else
            return response()->json(['data' => $results], 200);
    }
    /**
     * Show Substances actives
     *
     * @return View
     * @author Kazi_Sidou_WebSalafiDev
     */
    public function showSubstances()
    {

        $seconds = 604800; // One week
        $substances = Cache::remember('sub', $seconds, function () {
            return
                DB::table('sac_subactive')
                ->orderBy('sac_nom', 'asc')
                ->get();
        });
        return view('bddm.meds.meds_sac', compact('substances'));
    }


    /**
     * get medicaments of sac ID
     *
     * @return void
     * @author 
     */
    public function getSacMedicaments($sacID, $rd = null)
    {
        $results = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->where('sac_subactive.SAC_CODE_SQ_PK', $sacID)
            ->get();

        if ($rd == 'view')
            return view('bddm.meds.sac_equiv', compact('results'));

        return response()->json($results);
    }


    private function getFils($r)
    {

        if (isset($r->CATC_CODE_PK)) {
            $code_pk = $r->CATC_CODE_PK;

            $r1 = DB::table('catc_classeatc')->where('CATC_CATC_CODE_FK', $code_pk)
                ->select('CATC_CODE_PK', 'CATC_CATC_CODE_FK', 'CATC_NOMF')
                ->get();

            if (count($r1) == 0) return $r;

            else {
                for ($j = 0; $j < count($r1); $j++) {
                    $res[] = $this->getFils($r1[$j]);
                }
                return collect([$r])->put('fils', $res);
            }
        }
    }
    /**
     * return list of subclasses of atc and medicaments
     *
     * @return void
     * @author 
     */
    public function showSubClasses($id)
    {
        $r = DB::table('catc_classeatc')
            ->select('CATC_CODE_PK', 'CATC_CATC_CODE_FK', 'CATC_NOMF')
            ->where('CATC_CATC_CODE_FK',  $id)
            ->get();

        if (count($r) == 0) { // if there is no sub-classes
            // get the list of medicaments
            $medicaments = DB::table('sp_specialite')
                ->join('catc_classeatc', 'sp_specialite.sp_catc_code_fk', 'catc_classeatc.catc_code_pk')
                ->select('sp_specialite.sp_nom', 'sp_specialite.sp_code_sq_pk')
                ->where('catc_classeatc.catc_code_pk', '=', $id)
                ->get();
            if (count($medicaments) == 0) {
                $response = " Aucun médicaments trouvés !";
                return  response(['message' => $response], 500)
                    ->header('Content-Type', 'application/json');
            }

            return response()->json(['medicaments' => $medicaments], 200)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($r);
    }
    /**
     * Show Classes ATC
     *
     * @return View
     * @author Kazi Aouel Sid ahmed 
     */
    public function showClasses()
    {
        $seconds = 604800; // One week
        $r = Cache::remember('classes', $seconds, function () {
            return
                DB::table('catc_classeatc')
                ->select('CATC_CODE_PK', 'CATC_CATC_CODE_FK', 'CATC_NOMF')
                ->where('CATC_CATC_CODE_FK',  null)
                ->where('CATC_CODE_PK', '!=', 'x')
                ->where('CATC_CODE_PK', '!=', 'z')
                ->get();
        });
        return view('bddm.meds.meds_atc', compact('r'));
    }

    /**
     * return list of subPharmceutique classes and medicaments
     *
     * @return void
     * @author 
     */
    public function showSubPharmClasses($id)
    {
        $r = DB::table('cph_classepharmther')
            // ->select('CATC_CODE_PK','CATC_CATC_CODE_FK','CATC_NOMF')
            ->where('CPH_CPH_CODE_FK',  $id)
            ->get();

        if (count($r) == 0) { // if there is no sub-classes
            // get the list of medicaments
            $medicaments = DB::table('sp_specialite')
                ->join('spcph_specialite_classeph', 'sp_specialite.sp_code_sq_pk', 'spcph_specialite_classeph.SPCPH_SP_CODE_FK_PK')
                ->select('sp_specialite.sp_nom', 'sp_specialite.sp_code_sq_pk')
                ->where('spcph_specialite_classeph.SPCPH_CPH_CODE_FK_PK', '=', $id)
                ->get();
            if (count($medicaments) == 0) {
                $response = " Aucun médicaments trouvés !";
                return  response(['message' => $response], 500)
                    ->header('Content-Type', 'application/json');
            }

            return response()->json(['medicaments' => $medicaments], 200)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($r);
    }
    /**
     * Show pharmaceutiques classes
     *
     * @return View
     * @author Kazi Aouel Sid ahmed 
     */
    public function showPharmClasses()
    {
        $r = DB::table('cph_classepharmther')
            ->where('CPH_CPH_CODE_FK',  null)
            ->get();


        return view('bddm.meds.meds_cph', compact('r'));
    }
    /**
     * show specialites for specefic indication
     *
     * @return Specialites
     * @author kazi
     */
    public function showSpIndication($id)
    {
        $sps = DB::table('sp_specialite')
            ->join('finafs_fin_afssaps', 'finafs_fin_afssaps.FINAFS_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->join('fin_ficheindic', 'finafs_fin_afssaps.FINAFS_FIN_CODE_FK_PK', 'fin_ficheindic.FIN_CODE_SQ_PK')
            ->join('cdf_codif', 'fin_ficheindic.FIN_CDF_NAIN_CODE_FK_PK', 'cdf_codif.CDF_CODE_PK')
            ->where('cdf_codif.CDF_NUMERO_PK', 'NN')
            ->where('fin_ficheindic.FIN_CDF_NAIN_CODE_FK_PK', $id)
            ->select('sp_algerie', 'SP_NOM', 'SP_CODE_SQ_PK')
            ->distinct()
            ->get();
        if (count($sps) == 0) return response()->json(['message' => 'Aucun médicaments trouvés !'], 500);
        else
            return response()->json($sps, 200);
    }
    /**
     * show Indications
     *
     * @return viex
     * @author kazi
     */
    public function showIndications()
    {
        $indications = DB::table('fin_ficheindic')
            ->join('cdf_codif', 'fin_ficheindic.FIN_CDF_NAIN_CODE_FK_PK', 'cdf_codif.CDF_CODE_PK')
            ->where('cdf_codif.CDF_NUMERO_PK', 'NN')
            ->select('fin_ficheindic.FIN_CDF_NAIN_CODE_FK_PK', 'cdf_nom')
            ->distinct()
            ->get();

        return view('bddm.meds.meds_indic', compact('indications'));
    }
    /**
     * show monographie of drug
     *
     * @return view
     * @author Kazi Aouel Sid ahmed
     */
    public function getMonographie($medicament)
    {
        $sp = $this->getSP($medicament);

        if ($sp['0']->SP_ALGERIE == '1') {
            // Debugbar::startMeasure('render','Time for rendering getMedicamentsEquiv');
            $sps_equiv = $this->getMedicamentsEquiv($sp);
            // Debugbar::stopMeasure('render');
            return view('bddm.meds.meds_equiv', compact('sps_equiv'));
        }

        $dci = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->select('*', DB::raw("CONCAT(sac_subactive.SAC_NOM , ' ',cosac_compo_subact.COSAC_DOSAGE ,' ' ,cosac_compo_subact.COSAC_UNITEDOSAGE) AS dci"))
            ->toSql();

        $dci = DB::table(DB::raw(" ({$dci}) as p"))
            ->where('p.SP_CODE_SQ_PK', $medicament)
            ->select(DB::raw(" GROUP_CONCAT(p.dci SEPARATOR '/') as dci"))
            ->get();

        $dci = $dci['0']->dci;

        // Get Drug Sql Query
        $indications = DB::table('sp_specialite')
            ->join('finafs_fin_afssaps', 'finafs_fin_afssaps.FINAFS_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->join('fin_ficheindic', 'finafs_fin_afssaps.FINAFS_FIN_CODE_FK_PK', 'fin_ficheindic.FIN_CODE_SQ_PK')
            ->join('cdf_codif', 'fin_ficheindic.FIN_CDF_NAIN_CODE_FK_PK', 'cdf_codif.CDF_CODE_PK')
            ->where('cdf_codif.CDF_NUMERO_PK', 'NN')
            ->where('SP_CODE_SQ_PK', $medicament)
            ->select('sp_algerie', 'cdf_nom', DB::raw('DATE(fin_datemj) AS date_mj'))
            ->distinct()
            ->get();

        $posologies = DB::select("
            select p1.schem,
            CASE WHEN ipo.IPO_DOSEMIN is NOT NULL  AND ipo.IPO_DOSEMIN is NOT NULL THEN 
                  CONCAT(ipo.IPO_DOSEMIN, ' à ', ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMIN is NULL THEN CONCAT(ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMAX is NULL THEN CONCAT(ipo.IPO_DOSEMIN, ' ', cdf.CDF_NOM)
            END AS dose,

            CASE WHEN ipo.IPO_FREQMAX='.'  AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  cdf1.CDF_NOM
                 WHEN ipo.IPO_FREQMAX='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN
                     CONCAT(ipo.IPO_FREQMIN, '', cdf1.CDF_NOM) 
                 WHEN ipo.IPO_FREQMAX!='.' AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  CONCAT(ipo.IPO_FREQMAX,'',cdf1.CDF_NOM)
                 WHEN ipo.IPO_FREQMAX!='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN  CONCAT(ipo.IPO_FREQMIN,' à ',ipo.IPO_FREQMAX ,'', cdf1.CDF_NOM)
            END as frequence, 
            comment_f.cdf_comment_freq,

            CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NOT NULL and ipo.IPO_CDF_UTMAX_CODE_FK IS NOT NULL then
                  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM , ' à ', ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)   
                WHEN ipo.IPO_CDF_UTMAX_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM)
                WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)  
            END AS duree, 
            comment_d.cdf_comment_duree ,
  
            group_concat(p1.terrain SEPARATOR ',') as terrains,
            group_concat(p1.indication SEPARATOR ',') as indications,
            'usuelle' as type

             
                from
            (select 
            p.FPOSP_FPO_CODE_FK_PK as schem,
            group_concat(p.cdf_nom order by p.fpote_numord  asc SEPARATOR ' ') as terrain,
            null as indication
                        from 
                        (
                            select * from `sp_specialite`
                            INNER JOIN `fposp_poso_spe` ON `fposp_poso_spe`.`FPOSP_SP_CODE_FK_PK` = `sp_specialite`.`SP_CODE_SQ_PK`
                            INNER JOIN `fpote_fposo_terrain` ON `fposp_poso_spe`.`FPOSP_FPO_CODE_FK_PK` = `fpote_fposo_terrain`.`FPOTE_FPO_CODE_FK_PK`
                            INNER JOIN `cdf_codif` ON `cdf_codif`.`CDF_CODE_PK` = `fpote_fposo_terrain`.`FPOTE_CDF_TEPO_CODE_FK_PK`
                            WHERE 
                                `cdf_codif`.`CDF_NUMERO_PK` = 'PT' 
                                AND 
                                `sp_specialite`.`SP_CODE_SQ_PK` = ?
                             
                        ) as p
                        group by p.fpote_fpo_code_fk_pk,p.fpote_grp_code_pk
                        
                        union
                        select 
                            t1.fposp_fpo_code_fk_pk as schem,  
                        null            as terrain,
                        t3.cdf_nom      as indication         
                        from  fposp_poso_spe t1,fpout_fposo_utilth  t2,cdf_codif t3    
                        where  t1.fposp_fpo_code_fk_pk  = t2.fpout_fpo_code_fk_pk      
                        and    t3.cdf_code_pk           = t2.fpout_cdf_utpo_code_fk_pk 
                        and    t3.cdf_numero_pk         = 'NN'                       
                        and    t1.fposp_sp_code_fk_pk   = ?
                        
                        order by schem asc) as p1 
                        
                        left join ipo_infoposo as ipo on (p1.schem=ipo.ipo_fpo_code_fk_pk
                        and ipo.ipo_cdf_napo_code_fk='01')
                        
                        left join cdf_codif as cdf on (cdf.cdf_code_pk=ipo.IPO_CDF_UNPO_CODE_FK
                        and cdf.cdf_numero_pk='PP')
                        
                        left join cdf_codif as cdf1 on (cdf1.cdf_code_pk=ipo.IPO_CDF_FREQMAX_CODE_FK
                        and cdf1.cdf_numero_pk='PF')
                        
                        left join cdf_codif as cdf2 on (CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK !='' THEN 
                            cdf2.cdf_code_pk=ipo.IPO_CDF_UTMIN_CODE_FK and cdf2.cdf_numero_pk='PU'
                            END)
                        left join cdf_codif as cdf21 on (CASE WHEN ipo.IPO_CDF_UTMAX_CODE_FK !='' THEN 
                            cdf21.cdf_code_pk=ipo.IPO_CDF_UTMAX_CODE_FK and cdf21.cdf_numero_pk='PU'
                            END)


                        left join (select 
                              group_concat(cdf3.CDF_NOM ORDER BY IPOCOFQ_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_freq,
                              IPOCOFQ_IPO_CODE_FK_PK
                              from ipocofq_infpo_comment_freq
                               
                              left join cdf_codif as cdf3 on (cdf3.cdf_code_pk=ipocofq_infpo_comment_freq.IPOCOFQ_CDF_COFQ_CODE_FK_PK
                                 and cdf3.cdf_numero_pk='PC')
                                 
                              where IPOCOFQ_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOFQ_IPO_CODE_FK_PK

                        ) as comment_f on (ipo.IPO_FPO_CODE_FK_PK=comment_f.IPOCOFQ_IPO_CODE_FK_PK)


                        left join (select 
                              group_concat(cdf4.CDF_NOM ORDER BY IPOCOD_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_duree,
                              IPOCOD_IPO_CODE_FK_PK
                              from ipocod_infpo_comment_duree
                               
                              left join cdf_codif as cdf4 on (cdf4.cdf_code_pk=ipocod_infpo_comment_duree.IPOCOD_CDF_COD_CODE_FK_PK
                                 and cdf4.cdf_numero_pk='PC')
                                 
                              where IPOCOD_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOD_IPO_CODE_FK_PK

                        ) as comment_d on (ipo.IPO_FPO_CODE_FK_PK=comment_d.IPOCOD_IPO_CODE_FK_PK)

                group by p1.schem", [$medicament, $medicament]);

        if (count($posologies) == 0)
            $posologies = DB::select("
            select p1.schem,
            CASE WHEN ipo.IPO_DOSEMIN is NOT NULL  AND ipo.IPO_DOSEMIN is NOT NULL THEN 
                  CONCAT(ipo.IPO_DOSEMIN, ' à ', ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMIN is NULL THEN CONCAT(ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMAX is NULL THEN CONCAT(ipo.IPO_DOSEMIN, ' ', cdf.CDF_NOM)
            END AS dose,

            CASE WHEN ipo.IPO_FREQMAX='.'  AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  cdf1.CDF_NOM
                 WHEN ipo.IPO_FREQMAX='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN
                     CONCAT(ipo.IPO_FREQMIN, '', cdf1.CDF_NOM) 
                 WHEN ipo.IPO_FREQMAX!='.' AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  CONCAT(ipo.IPO_FREQMAX,'',cdf1.CDF_NOM)
                 WHEN ipo.IPO_FREQMAX!='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN  CONCAT(ipo.IPO_FREQMIN,' à ',ipo.IPO_FREQMAX ,'', cdf1.CDF_NOM)
            END as frequence, 
            comment_f.cdf_comment_freq,

            CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NOT NULL and ipo.IPO_CDF_UTMAX_CODE_FK IS NOT NULL then
                  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM , ' à ', ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)   
                WHEN ipo.IPO_CDF_UTMAX_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM)
                WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)  
            END AS duree, 
            comment_d.cdf_comment_duree ,
  
            group_concat(p1.terrain SEPARATOR ',') as terrains,
            group_concat(p1.indication SEPARATOR ',') as indications,
            'Initiale' as type

             
                from
            (select 
            p.FPOSP_FPO_CODE_FK_PK as schem,
            group_concat(p.cdf_nom order by p.fpote_numord  asc SEPARATOR ' ') as terrain,
            null as indication
                        from 
                        (
                            select * from `sp_specialite`
                            INNER JOIN `fposp_poso_spe` ON `fposp_poso_spe`.`FPOSP_SP_CODE_FK_PK` = `sp_specialite`.`SP_CODE_SQ_PK`
                            INNER JOIN `fpote_fposo_terrain` ON `fposp_poso_spe`.`FPOSP_FPO_CODE_FK_PK` = `fpote_fposo_terrain`.`FPOTE_FPO_CODE_FK_PK`
                            INNER JOIN `cdf_codif` ON `cdf_codif`.`CDF_CODE_PK` = `fpote_fposo_terrain`.`FPOTE_CDF_TEPO_CODE_FK_PK`
                            WHERE 
                                `cdf_codif`.`CDF_NUMERO_PK` = 'PT' 
                                AND 
                                `sp_specialite`.`SP_CODE_SQ_PK` = ?
                             
                        ) as p
                        group by p.fpote_fpo_code_fk_pk,p.fpote_grp_code_pk
                        
                        union
                        select 
                            t1.fposp_fpo_code_fk_pk as schem,  
                        null            as terrain,
                        t3.cdf_nom      as indication         
                        from  fposp_poso_spe t1,fpout_fposo_utilth  t2,cdf_codif t3    
                        where  t1.fposp_fpo_code_fk_pk  = t2.fpout_fpo_code_fk_pk      
                        and    t3.cdf_code_pk           = t2.fpout_cdf_utpo_code_fk_pk 
                        and    t3.cdf_numero_pk         = 'NN'                       
                        and    t1.fposp_sp_code_fk_pk   = ?
                        
                        order by schem asc) as p1 
                        
                        left join ipo_infoposo as ipo on (p1.schem=ipo.ipo_fpo_code_fk_pk
                        and ipo.ipo_cdf_napo_code_fk='03')
                        
                        left join cdf_codif as cdf on (cdf.cdf_code_pk=ipo.IPO_CDF_UNPO_CODE_FK
                        and cdf.cdf_numero_pk='PP')
                        
                        left join cdf_codif as cdf1 on (cdf1.cdf_code_pk=ipo.IPO_CDF_FREQMAX_CODE_FK
                        and cdf1.cdf_numero_pk='PF')
                        
                        left join cdf_codif as cdf2 on (CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK !='' THEN 
                            cdf2.cdf_code_pk=ipo.IPO_CDF_UTMIN_CODE_FK and cdf2.cdf_numero_pk='PU'
                            END)
                        left join cdf_codif as cdf21 on (CASE WHEN ipo.IPO_CDF_UTMAX_CODE_FK !='' THEN 
                            cdf21.cdf_code_pk=ipo.IPO_CDF_UTMAX_CODE_FK and cdf21.cdf_numero_pk='PU'
                            END)


                        left join (select 
                              group_concat(cdf3.CDF_NOM ORDER BY IPOCOFQ_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_freq,
                              IPOCOFQ_IPO_CODE_FK_PK
                              from ipocofq_infpo_comment_freq
                               
                              left join cdf_codif as cdf3 on (cdf3.cdf_code_pk=ipocofq_infpo_comment_freq.IPOCOFQ_CDF_COFQ_CODE_FK_PK
                                 and cdf3.cdf_numero_pk='PC')
                                 
                              where IPOCOFQ_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOFQ_IPO_CODE_FK_PK

                        ) as comment_f on (ipo.IPO_FPO_CODE_FK_PK=comment_f.IPOCOFQ_IPO_CODE_FK_PK)


                        left join (select 
                              group_concat(cdf4.CDF_NOM ORDER BY IPOCOD_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_duree,
                              IPOCOD_IPO_CODE_FK_PK
                              from ipocod_infpo_comment_duree
                               
                              left join cdf_codif as cdf4 on (cdf4.cdf_code_pk=ipocod_infpo_comment_duree.IPOCOD_CDF_COD_CODE_FK_PK
                                 and cdf4.cdf_numero_pk='PC')
                                 
                              where IPOCOD_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOD_IPO_CODE_FK_PK

                        ) as comment_d on (ipo.IPO_FPO_CODE_FK_PK=comment_d.IPOCOD_IPO_CODE_FK_PK)

                group by p1.schem", [$medicament, $medicament]);


        if (count($posologies) == 0)
            $posologies = DB::select("
            select p1.schem,
            CASE WHEN ipo.IPO_DOSEMIN is NOT NULL  AND ipo.IPO_DOSEMIN is NOT NULL THEN 
                  CONCAT(ipo.IPO_DOSEMIN, ' à ', ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMIN is NULL THEN CONCAT(ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMAX is NULL THEN CONCAT(ipo.IPO_DOSEMIN, ' ', cdf.CDF_NOM)
            END AS dose,

            CASE WHEN ipo.IPO_FREQMAX='.'  AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  cdf1.CDF_NOM
                 WHEN ipo.IPO_FREQMAX='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN
                     CONCAT(ipo.IPO_FREQMIN, '', cdf1.CDF_NOM) 
                 WHEN ipo.IPO_FREQMAX!='.' AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  CONCAT(ipo.IPO_FREQMAX,'',cdf1.CDF_NOM)
                 WHEN ipo.IPO_FREQMAX!='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN  CONCAT(ipo.IPO_FREQMIN,' à ',ipo.IPO_FREQMAX ,'', cdf1.CDF_NOM)
            END as frequence, 
            comment_f.cdf_comment_freq,

            CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NOT NULL and ipo.IPO_CDF_UTMAX_CODE_FK IS NOT NULL then
                  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM , ' à ', ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)   
                WHEN ipo.IPO_CDF_UTMAX_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM)
                WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)  
            END AS duree, 
            comment_d.cdf_comment_duree ,
  
            group_concat(p1.terrain SEPARATOR ',') as terrains,
            group_concat(p1.indication SEPARATOR ',') as indications,
            'entretien' as type

             
                from
            (select 
            p.FPOSP_FPO_CODE_FK_PK as schem,
            group_concat(p.cdf_nom order by p.fpote_numord  asc SEPARATOR ' ') as terrain,
            null as indication
                        from 
                        (
                            select * from `sp_specialite`
                            INNER JOIN `fposp_poso_spe` ON `fposp_poso_spe`.`FPOSP_SP_CODE_FK_PK` = `sp_specialite`.`SP_CODE_SQ_PK`
                            INNER JOIN `fpote_fposo_terrain` ON `fposp_poso_spe`.`FPOSP_FPO_CODE_FK_PK` = `fpote_fposo_terrain`.`FPOTE_FPO_CODE_FK_PK`
                            INNER JOIN `cdf_codif` ON `cdf_codif`.`CDF_CODE_PK` = `fpote_fposo_terrain`.`FPOTE_CDF_TEPO_CODE_FK_PK`
                            WHERE 
                                `cdf_codif`.`CDF_NUMERO_PK` = 'PT' 
                                AND 
                                `sp_specialite`.`SP_CODE_SQ_PK` = ?
                             
                        ) as p
                        group by p.fpote_fpo_code_fk_pk,p.fpote_grp_code_pk
                        
                        union
                        select 
                            t1.fposp_fpo_code_fk_pk as schem,  
                        null            as terrain,
                        t3.cdf_nom      as indication         
                        from  fposp_poso_spe t1,fpout_fposo_utilth  t2,cdf_codif t3    
                        where  t1.fposp_fpo_code_fk_pk  = t2.fpout_fpo_code_fk_pk      
                        and    t3.cdf_code_pk           = t2.fpout_cdf_utpo_code_fk_pk 
                        and    t3.cdf_numero_pk         = 'NN'                       
                        and    t1.fposp_sp_code_fk_pk   = ?
                        
                        order by schem asc) as p1 
                        
                        left join ipo_infoposo as ipo on (p1.schem=ipo.ipo_fpo_code_fk_pk
                        and ipo.ipo_cdf_napo_code_fk='04')
                        
                        left join cdf_codif as cdf on (cdf.cdf_code_pk=ipo.IPO_CDF_UNPO_CODE_FK
                        and cdf.cdf_numero_pk='PP')
                        
                        left join cdf_codif as cdf1 on (cdf1.cdf_code_pk=ipo.IPO_CDF_FREQMAX_CODE_FK
                        and cdf1.cdf_numero_pk='PF')
                        
                        left join cdf_codif as cdf2 on (CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK !='' THEN 
                            cdf2.cdf_code_pk=ipo.IPO_CDF_UTMIN_CODE_FK and cdf2.cdf_numero_pk='PU'
                            END)
                        left join cdf_codif as cdf21 on (CASE WHEN ipo.IPO_CDF_UTMAX_CODE_FK !='' THEN 
                            cdf21.cdf_code_pk=ipo.IPO_CDF_UTMAX_CODE_FK and cdf21.cdf_numero_pk='PU'
                            END)


                        left join (select 
                              group_concat(cdf3.CDF_NOM ORDER BY IPOCOFQ_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_freq,
                              IPOCOFQ_IPO_CODE_FK_PK
                              from ipocofq_infpo_comment_freq
                               
                              left join cdf_codif as cdf3 on (cdf3.cdf_code_pk=ipocofq_infpo_comment_freq.IPOCOFQ_CDF_COFQ_CODE_FK_PK
                                 and cdf3.cdf_numero_pk='PC')
                                 
                              where IPOCOFQ_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOFQ_IPO_CODE_FK_PK

                        ) as comment_f on (ipo.IPO_FPO_CODE_FK_PK=comment_f.IPOCOFQ_IPO_CODE_FK_PK)


                        left join (select 
                              group_concat(cdf4.CDF_NOM ORDER BY IPOCOD_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_duree,
                              IPOCOD_IPO_CODE_FK_PK
                              from ipocod_infpo_comment_duree
                               
                              left join cdf_codif as cdf4 on (cdf4.cdf_code_pk=ipocod_infpo_comment_duree.IPOCOD_CDF_COD_CODE_FK_PK
                                 and cdf4.cdf_numero_pk='PC')
                                 
                              where IPOCOD_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOD_IPO_CODE_FK_PK

                        ) as comment_d on (ipo.IPO_FPO_CODE_FK_PK=comment_d.IPOCOD_IPO_CODE_FK_PK)

                group by p1.schem", [$medicament, $medicament]);

        if (count($posologies) == 0)
            $posologies = DB::select("
            select p1.schem,
            CASE WHEN ipo.IPO_DOSEMIN is NOT NULL  AND ipo.IPO_DOSEMIN is NOT NULL THEN 
                  CONCAT(ipo.IPO_DOSEMIN, ' à ', ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMIN is NULL THEN CONCAT(ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMAX is NULL THEN CONCAT(ipo.IPO_DOSEMIN, ' ', cdf.CDF_NOM)
            END AS dose,

            CASE WHEN ipo.IPO_FREQMAX='.'  AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  cdf1.CDF_NOM
                 WHEN ipo.IPO_FREQMAX='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN
                     CONCAT(ipo.IPO_FREQMIN, '', cdf1.CDF_NOM) 
                 WHEN ipo.IPO_FREQMAX!='.' AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  CONCAT(ipo.IPO_FREQMAX,'',cdf1.CDF_NOM)
                 WHEN ipo.IPO_FREQMAX!='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN  CONCAT(ipo.IPO_FREQMIN,' à ',ipo.IPO_FREQMAX ,'', cdf1.CDF_NOM)
            END as frequence, 
            comment_f.cdf_comment_freq,

            CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NOT NULL and ipo.IPO_CDF_UTMAX_CODE_FK IS NOT NULL then
                  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM , ' à ', ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)   
                WHEN ipo.IPO_CDF_UTMAX_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM)
                WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)  
            END AS duree, 
            comment_d.cdf_comment_duree ,
  
            group_concat(p1.terrain SEPARATOR ',') as terrains,
            group_concat(p1.indication SEPARATOR ',') as indications,
            'attaque' as type

             
                from
            (select 
            p.FPOSP_FPO_CODE_FK_PK as schem,
            group_concat(p.cdf_nom order by p.fpote_numord  asc SEPARATOR ' ') as terrain,
            null as indication
                        from 
                        (
                            select * from `sp_specialite`
                            INNER JOIN `fposp_poso_spe` ON `fposp_poso_spe`.`FPOSP_SP_CODE_FK_PK` = `sp_specialite`.`SP_CODE_SQ_PK`
                            INNER JOIN `fpote_fposo_terrain` ON `fposp_poso_spe`.`FPOSP_FPO_CODE_FK_PK` = `fpote_fposo_terrain`.`FPOTE_FPO_CODE_FK_PK`
                            INNER JOIN `cdf_codif` ON `cdf_codif`.`CDF_CODE_PK` = `fpote_fposo_terrain`.`FPOTE_CDF_TEPO_CODE_FK_PK`
                            WHERE 
                                `cdf_codif`.`CDF_NUMERO_PK` = 'PT' 
                                AND 
                                `sp_specialite`.`SP_CODE_SQ_PK` = ?
                             
                        ) as p
                        group by p.fpote_fpo_code_fk_pk,p.fpote_grp_code_pk
                        
                        union
                        select 
                            t1.fposp_fpo_code_fk_pk as schem,  
                        null            as terrain,
                        t3.cdf_nom      as indication         
                        from  fposp_poso_spe t1,fpout_fposo_utilth  t2,cdf_codif t3    
                        where  t1.fposp_fpo_code_fk_pk  = t2.fpout_fpo_code_fk_pk      
                        and    t3.cdf_code_pk           = t2.fpout_cdf_utpo_code_fk_pk 
                        and    t3.cdf_numero_pk         = 'NN'                       
                        and    t1.fposp_sp_code_fk_pk   = ?
                        
                        order by schem asc) as p1 
                        
                        left join ipo_infoposo as ipo on (p1.schem=ipo.ipo_fpo_code_fk_pk
                        and ipo.ipo_cdf_napo_code_fk='05')
                        
                        left join cdf_codif as cdf on (cdf.cdf_code_pk=ipo.IPO_CDF_UNPO_CODE_FK
                        and cdf.cdf_numero_pk='PP')
                        
                        left join cdf_codif as cdf1 on (cdf1.cdf_code_pk=ipo.IPO_CDF_FREQMAX_CODE_FK
                        and cdf1.cdf_numero_pk='PF')
                        
                        left join cdf_codif as cdf2 on (CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK !='' THEN 
                            cdf2.cdf_code_pk=ipo.IPO_CDF_UTMIN_CODE_FK and cdf2.cdf_numero_pk='PU'
                            END)
                        left join cdf_codif as cdf21 on (CASE WHEN ipo.IPO_CDF_UTMAX_CODE_FK !='' THEN 
                            cdf21.cdf_code_pk=ipo.IPO_CDF_UTMAX_CODE_FK and cdf21.cdf_numero_pk='PU'
                            END)


                        left join (select 
                              group_concat(cdf3.CDF_NOM ORDER BY IPOCOFQ_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_freq,
                              IPOCOFQ_IPO_CODE_FK_PK
                              from ipocofq_infpo_comment_freq
                               
                              left join cdf_codif as cdf3 on (cdf3.cdf_code_pk=ipocofq_infpo_comment_freq.IPOCOFQ_CDF_COFQ_CODE_FK_PK
                                 and cdf3.cdf_numero_pk='PC')
                                 
                              where IPOCOFQ_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOFQ_IPO_CODE_FK_PK

                        ) as comment_f on (ipo.IPO_FPO_CODE_FK_PK=comment_f.IPOCOFQ_IPO_CODE_FK_PK)


                        left join (select 
                              group_concat(cdf4.CDF_NOM ORDER BY IPOCOD_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_duree,
                              IPOCOD_IPO_CODE_FK_PK
                              from ipocod_infpo_comment_duree
                               
                              left join cdf_codif as cdf4 on (cdf4.cdf_code_pk=ipocod_infpo_comment_duree.IPOCOD_CDF_COD_CODE_FK_PK
                                 and cdf4.cdf_numero_pk='PC')
                                 
                              where IPOCOD_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOD_IPO_CODE_FK_PK

                        ) as comment_d on (ipo.IPO_FPO_CODE_FK_PK=comment_d.IPOCOD_IPO_CODE_FK_PK)

                group by p1.schem", [$medicament, $medicament]);

        if (count($posologies) == 0)
            $posologies = DB::select("
            select p1.schem,
            CASE WHEN ipo.IPO_DOSEMIN is NOT NULL  AND ipo.IPO_DOSEMIN is NOT NULL THEN 
                  CONCAT(ipo.IPO_DOSEMIN, ' à ', ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMIN is NULL THEN CONCAT(ipo.IPO_DOSEMAX, ' ', cdf.CDF_NOM)
                WHEN ipo.IPO_DOSEMAX is NULL THEN CONCAT(ipo.IPO_DOSEMIN, ' ', cdf.CDF_NOM)
            END AS dose,

            CASE WHEN ipo.IPO_FREQMAX='.'  AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  cdf1.CDF_NOM
                 WHEN ipo.IPO_FREQMAX='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN
                     CONCAT(ipo.IPO_FREQMIN, '', cdf1.CDF_NOM) 
                 WHEN ipo.IPO_FREQMAX!='.' AND (ipo.IPO_CDF_FREQMIN_CODE_FK IS NULL OR ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL) AND ipo.IPO_FREQMIN IS NULL THEN  CONCAT(ipo.IPO_FREQMAX,'',cdf1.CDF_NOM)
                 WHEN ipo.IPO_FREQMAX!='.' AND ipo.IPO_CDF_FREQMIN_CODE_FK IS NOT NULL AND ipo.IPO_FREQMIN IS NOT NULL THEN  CONCAT(ipo.IPO_FREQMIN,' à ',ipo.IPO_FREQMAX ,'', cdf1.CDF_NOM)
            END as frequence, 
            comment_f.cdf_comment_freq,

            CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NOT NULL and ipo.IPO_CDF_UTMAX_CODE_FK IS NOT NULL then
                  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM , ' à ', ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)   
                WHEN ipo.IPO_CDF_UTMAX_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMIN, ' ', cdf2.CDF_NOM)
                WHEN ipo.IPO_CDF_UTMIN_CODE_FK IS NULL THEN  CONCAT(ipo.IPO_DUREEMAX, ' ', cdf21.CDF_NOM)  
            END AS duree, 
            comment_d.cdf_comment_duree ,
  
            group_concat(p1.terrain SEPARATOR ',') as terrains,
            group_concat(p1.indication SEPARATOR ',') as indications,
            'cumulee' as type

             
                from
            (select 
            p.FPOSP_FPO_CODE_FK_PK as schem,
            group_concat(p.cdf_nom order by p.fpote_numord  asc SEPARATOR ' ') as terrain,
            null as indication
                        from 
                        (
                            select * from `sp_specialite`
                            INNER JOIN `fposp_poso_spe` ON `fposp_poso_spe`.`FPOSP_SP_CODE_FK_PK` = `sp_specialite`.`SP_CODE_SQ_PK`
                            INNER JOIN `fpote_fposo_terrain` ON `fposp_poso_spe`.`FPOSP_FPO_CODE_FK_PK` = `fpote_fposo_terrain`.`FPOTE_FPO_CODE_FK_PK`
                            INNER JOIN `cdf_codif` ON `cdf_codif`.`CDF_CODE_PK` = `fpote_fposo_terrain`.`FPOTE_CDF_TEPO_CODE_FK_PK`
                            WHERE 
                                `cdf_codif`.`CDF_NUMERO_PK` = 'PT' 
                                AND 
                                `sp_specialite`.`SP_CODE_SQ_PK` = ?
                             
                        ) as p
                        group by p.fpote_fpo_code_fk_pk,p.fpote_grp_code_pk
                        
                        union
                        select 
                            t1.fposp_fpo_code_fk_pk as schem,  
                        null            as terrain,
                        t3.cdf_nom      as indication         
                        from  fposp_poso_spe t1,fpout_fposo_utilth  t2,cdf_codif t3    
                        where  t1.fposp_fpo_code_fk_pk  = t2.fpout_fpo_code_fk_pk      
                        and    t3.cdf_code_pk           = t2.fpout_cdf_utpo_code_fk_pk 
                        and    t3.cdf_numero_pk         = 'NN'                       
                        and    t1.fposp_sp_code_fk_pk   = ?
                        
                        order by schem asc) as p1 
                        
                        left join ipo_infoposo as ipo on (p1.schem=ipo.ipo_fpo_code_fk_pk
                        and ipo.ipo_cdf_napo_code_fk='6')
                        
                        left join cdf_codif as cdf on (cdf.cdf_code_pk=ipo.IPO_CDF_UNPO_CODE_FK
                        and cdf.cdf_numero_pk='PP')
                        
                        left join cdf_codif as cdf1 on (cdf1.cdf_code_pk=ipo.IPO_CDF_FREQMAX_CODE_FK
                        and cdf1.cdf_numero_pk='PF')
                        
                        left join cdf_codif as cdf2 on (CASE WHEN ipo.IPO_CDF_UTMIN_CODE_FK !='' THEN 
                            cdf2.cdf_code_pk=ipo.IPO_CDF_UTMIN_CODE_FK and cdf2.cdf_numero_pk='PU'
                            END)
                        left join cdf_codif as cdf21 on (CASE WHEN ipo.IPO_CDF_UTMAX_CODE_FK !='' THEN 
                            cdf21.cdf_code_pk=ipo.IPO_CDF_UTMAX_CODE_FK and cdf21.cdf_numero_pk='PU'
                            END)


                        left join (select 
                              group_concat(cdf3.CDF_NOM ORDER BY IPOCOFQ_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_freq,
                              IPOCOFQ_IPO_CODE_FK_PK
                              from ipocofq_infpo_comment_freq
                               
                              left join cdf_codif as cdf3 on (cdf3.cdf_code_pk=ipocofq_infpo_comment_freq.IPOCOFQ_CDF_COFQ_CODE_FK_PK
                                 and cdf3.cdf_numero_pk='PC')
                                 
                              where IPOCOFQ_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOFQ_IPO_CODE_FK_PK

                        ) as comment_f on (ipo.IPO_FPO_CODE_FK_PK=comment_f.IPOCOFQ_IPO_CODE_FK_PK)


                        left join (select 
                              group_concat(cdf4.CDF_NOM ORDER BY IPOCOD_NUM_ORD_PK ASC SEPARATOR '&lt;br/&gt;' ) as cdf_comment_duree,
                              IPOCOD_IPO_CODE_FK_PK
                              from ipocod_infpo_comment_duree
                               
                              left join cdf_codif as cdf4 on (cdf4.cdf_code_pk=ipocod_infpo_comment_duree.IPOCOD_CDF_COD_CODE_FK_PK
                                 and cdf4.cdf_numero_pk='PC')
                                 
                              where IPOCOD_IPO_NUM_SEQ_FK_PK='1'
   
                              group by IPOCOD_IPO_CODE_FK_PK

                        ) as comment_d on (ipo.IPO_FPO_CODE_FK_PK=comment_d.IPOCOD_IPO_CODE_FK_PK)

                group by p1.schem", [$medicament, $medicament]);

        $cis = DB::select("
            select       
               distinct(t3.cdf_nom)  as terrain

            from         fcpmsp_cipemg_spe              t1 
            inner join   tercom_terrain_commentaire         t2 on t1.FCPMSP_FCPM_CODE_FK_PK = t2.TERCOM_FCPM_CODE_FK_PK 
            inner join   cdf_codif                      t3 on t2.TERCOM_CDF_COM_CODE_FK_PK = t3.cdf_code_pk 

            where t1.fcpmsp_sp_code_fk_pk          = ? 
                AND t3.cdf_numero_pk                = 'CC'
                AND t2.TERCOM_NATURE_CIPEMG_FK_PK   ='C'
            ", [$medicament]);

        //effets indésirables
        $effets = DB::select("
            SELECT   
                t3.cdf_nom              AS effet
             
            FROM     feisp_effindspe t1,feinact_naturether_eiclin t2, cdf_codif t3 

            WHERE    t1.feisp_fei_code_fk_pk = t2.feinact_fei_code_fk_pk 
                   AND t2.feinact_cdf_naei_code_fk_pk = t3.cdf_code_pk 
                   AND t3.cdf_numero_pk = 'EN' 
                   AND t1.feisp_sp_code_fk_pk = ? 
            ORDER BY t2.feinact_fei_code_fk_pk, 
                    t2.feinact_numord
            ", [$medicament]);

        $result = array(
            'medicament'  => $sp[0]->SP_NOM,
            'dci'         => $dci,
            'cph'   =>  $sp[0]->CPH_NOM,
            'indications' => $indications,
            'posologies'  => $posologies,
            'cis'         => $cis,
            'effets'      => $effets,
            'mono'        => '1'
        );

        // return $result;
        if ($result)
            //return $result; 
            return view('bddm.monographie', compact('result'));

        return redirect()->back()->with('message', 'Médicament Introuvable');
    }

    public function generatePages()
    {
        $start_time = microtime(true);

        $results = DB::table('sp_specialite')
            ->select(DB::raw("distinct (SP_NOM) as SP_NOM"), 'SP_CODE_SQ_PK')
            ->where('SP_ALGERIE', NULL)
            ->orderBy('SP_NOM', 'asc')
            ->limit(100)
            ->get();

        foreach ($results as $value) {
            $indicationss = "";
            $posologies = "";
            $effets = "";
            $cis = "";
            $result = $this->getMonographie($value->SP_CODE_SQ_PK);
            if (isset($result['indications']))
                foreach ($result['indications'] as $indic)
                    $indicationss .= "<li class='list-group-item'>  $indic->cdf_nom  </li>";

            if (isset($result['posologies']))
                foreach ($result['posologies'] as $key => $poso) {
                    $posologies .= "<tr> <td><b>Protocole posologique N°" . ($key + 1) . "</b></td> <td></td> </tr><tr>";
                    if ($poso->terrains) {
                        $posologies .= "<td>Terrain Physiopathologique</td>";
                        $terrains = explode(',', $poso->terrains);
                        $posologies .= "<td>";
                        foreach ($terrains as $terrain)
                            $posologies .= $terrain . "<br/>";
                        $posologies .= "</td>";
                    }
                    $posologies .= "</tr>";
                    $posologies .= "<tr>";
                    if ($poso->indications) {
                        $posologies .= "<td>Indication</td>";
                        $indications = explode(',', $poso->indications);
                        $posologies .= "<td>";
                        foreach ($indications as $indication)
                            $posologies .= $indication . "<br/>";

                        $posologies .= "</td>";
                    }

                    $posologies .= "</tr>";
                    if ($poso->dose) {
                        $posologies .= "<tr>";
                        $posologies .= "<td>Dose usuelle</td>";
                        $posologies .= "<td>" . $poso->dose . "</td>";
                        $posologies .= "</tr>";
                    }
                    if ($poso->frequence || $poso->cdf_comment_freq) {
                        $posologies .= "<tr>";
                        $posologies .= "<td>Fréquence usuelle</td>";
                        $posologies .= "<td>" . $poso->frequence . " " . html_entity_decode($poso->cdf_comment_freq) . "</td>";
                        $posologies .= "</tr>";
                    }
                    if ($poso->duree || $poso->cdf_comment_duree) {
                        $posologies .= "<tr>";
                        $posologies .= "<td>Durée du traitement</td>";
                        $posologies .= "<td>" . $poso->duree . "<br/>" . html_entity_decode($poso->cdf_comment_duree) . "</td>";
                        $posologies .= "</tr>";
                    }
                }
            $cis .= "<table class='table'>";
            if (isset($result['cis']))
                foreach ($result['cis'] as $key => $ci) {
                    $cis .= "<tr>";
                    $cis .= "<td>" . ($key == '0' ? "<b>Protocole Physiopathologique:</b>" : '') . "</td>";
                    $cis .= "<td>" . ($key != '0' ? $ci->terrain : '') . "</td>";
                    $cis .= "</tr>";
                }
            $cis .= "</table>";
            if (isset($result['effets']))
                foreach ($result['effets'] as $effet)
                    $effets .= "<li class='list-group-item'>" . $effet->effet . "</li>";

            $myFile = "Medicaments/" . strtolower(str_replace(array('/', ' '), array('-', '-'), $value->SP_NOM)) . ".html";


            $fh = fopen($myFile, 'w'); // or die("error");  
            // Open the file to get existing content
            $current = file_get_contents($myFile);
            //Append a new person to the file
            $current .= "
            <!DOCTYPE html>
            <html lang='fr'>
                
                <head>
                <title></title>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <link href='https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap' rel='stylesheet'>
                <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
                <meta name='csrf-token' content='Dzeky6OR2G6769y1zOWnZSYC9GRSwmtCRR8qGsza'>
                <link rel='icon'       href='http://localhost:8000/images/logo.png'>
                <link rel='stylesheet' href='http://localhost:8000/bddm/css/bootstrap.css'>
                <link rel='stylesheet' href='http://localhost:8000/bddm/fonts/all.min.css'>        
                <link rel='stylesheet' href='http://localhost:8000/css/Ionicons/css/ionicons.min.css'>
                <link rel='stylesheet' href='http://localhost:8000/bddm/css/jquery_ui.css'>
                <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css'>
                <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css'>
                <link rel='stylesheet' href='http://localhost:8000/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css'>
                <link rel='stylesheet' href='http://localhost:8000/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css'>
                <link rel='stylesheet' href='http://localhost:8000/bddm/css/main.css'>
            </head>
                <body>
                    <div class='d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm'>
                      <nav class='my-2 my-md-0 mr-md-3 offset-md-3'>
                        <a class='p-2 text-dark' href='#'>A-propos</a>
                        
                        <a class='p-2 text-dark' href='#'>Nos Formations</a>
                        <a class='p-2 text-dark' href='#'>Nos Prestation</a>
                        <a class='p-2 text-dark' href='#'>Nos Partenaires</a>
                      </nav>
                    </div>

                    <div class='container-fluid'>

                    <div class='row d-flex justify-content-center' style='background-color: #00e7ffc2; background-image: linear-gradient(to bottom right, #008bb594, #ffff0082);'>
                        <div class='bg-white col-sm-7 p-3 shadow m-3'>
                            <h1 style='text-align: center'>Recherchez votre médicament</h1>
                            <div class='input-group mb-3'>
                              
                              <input id='med_search' style='min-width:0px' class='form-control' placeholder='Entrer le nom commercial d'un médicament' >
                                                
                            </div>                  
                        
                            <ul class='nav nav-pills justify-content-center'>
                                <div class='sport-item'>
                                    <a href='http://localhost:8000/medicaments'>
                                        <div class='img-wrapper'>
                                            <img class='js-img-lazy js-img-lazy-loaded' src='http://localhost:8000/bddm/images/icon-3.png'  alt='' style='width:80px;height:80px' data-lazy-fade='1000' >
                                        </div>
                                        <div class='sports-label'>MEDICAMENTS</div>
                                    </a>
                                </div>
                                <div class='sport-item'>
                                    <a href='http://localhost:8000/substances'>
                                        <div class='img-wrapper'>
                                            <img class='js-img-lazy js-img-lazy-loaded' src='http://localhost:8000/bddm/images/icon-1.png'  alt='' style='width:80px;height:80px' data-lazy-fade='1000' >
                                        </div>
                                        <div class='sports-label'>SUBSTANCES</div>
                                    </a>
                                </div>    
                                <div class='sport-item'>
                                    <a href='http://localhost:8000/classes'>
                                        <div class='img-wrapper'>
                                            <img class='js-img-lazy js-img-lazy-loaded' src='http://localhost:8000/bddm/images/icon-2.png'  alt='' style='width:80px;height:80px' data-lazy-fade='1000' >
                                        </div>
                                        <div class='sports-label'>CLASSES ATC</div>
                                    </a>
                                </div>    
                                <div class='sport-item'>
                                    <a href='http://localhost:8000/indications'>
                                        <div class='img-wrapper'>
                                            <img class='js-img-lazy js-img-lazy-loaded' src='http://localhost:8000/bddm/images/icon-4.png'  alt='' style='width:80px;height:80px' data-lazy-fade='1000' >
                                        </div>
                                        <div class='sports-label'>INDICATIONS</div>
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-10 mt-1'>
                            <nav aria-label='breadcrumb'>
                              <ol class='breadcrumb' style='background-color: white'>
                                
                                <li class='breadcrumb-item'><a href='http://localhost:8000/medicaments'><i class='fas fa-capsules'></i> Médicaments</a></li>
                                <li class='breadcrumb-item active' aria-current='page'>ASPIRINE RCA 500MG CPR <span class='badge badge-danger'>SP</span></li>
                              </ol>
                            </nav>
                        </div>
                        <div class='d-block px-5 py-xl-3 noVisit'>
                          <a href='#print'    role='button' onclick='window.print()'><i class='fas fa-print'></i> Print</a>
                          
                          <a href='#bookmark' role='button' onclick='ga('send', 'social', 'DDC', 'Save or Share Top');'><i class='fas fa-share'></i> Share</a>
                        </div>
                    </div>
                        <h1>{$result['medicament']}</h1>" .
                ((isset($result['dci']) && !empty($result['dci'])) ? "<p>" . $result['dci'] . " <span class='badge badge-pill badge-success'>DCI</span> </p>" : '')
                . "<div class='col-sm-10 bhoechie-tab-container'>
                        <div class='row  d-flex justify-content-center'>
                            <div class='col-sm-3 bhoechie-tab-menu'>
                              <div class='list-group'>
                                
                                
                                <a href='#' class='list-group-item text-center'>
                                  <h4 class='fas fa-arrow-alt-circle-right fa-2x '></h4><br/>Indications
                                </a>
                                <a href='#' class='list-group-item text-center'>
                                  <h4 class='fas fa-clock fa-2x '></h4><br/>Posologie/Administration
                                </a>
                                <a href='#' class='list-group-item text-center'>
                                  <h4 class='fas fa-thermometer-three-quarters fa-2x  '></h4><br/>Contre Indication
                                </a>
                                <a href='#' class='list-group-item text-center'>
                                  <h4 class='fas fa-thermometer-quarter fa-2x  '></h4><br/>Effets indésirables
                                </a>
                                                                               
                              </div>
                            </div>
                        <div class='col-sm-9 bhoechie-tab'>
                            <!-- flight section -->
                            <div class='bhoechie-tab-content active'>
                                <center>
                                  <h1 class=' -plane' style='font-size:14em;color:#EC790C'></h1>
                                  <h2 style='margin-top: 0;color:#EC790C'>Indications</h2>
                                  <br>
                    
                                </center>
                                <h3 style='color:#EC790C'> Types de maladies</h3>
                                <ul class='list-group list-group-flush'>" .
                $indicationss
                . "</ul>
                            </div>
                            <!-- posologie section -->
                            <div class='bhoechie-tab-content'>
                                <center>
                                  <h1 class=' -road' style='font-size:12em;color:#EC790C'></h1>
                                  <h2 style='margin-top: 0;color:#EC790C'>Posologie(s)</h2>
                                  <br>
                                  
                                </center>
                                <table class='table'>" .
                $posologies
                . "</table>
                                <br>
                            </div>
                
                            <!-- hotel search -->
                            <div class='bhoechie-tab-content'>
                                <center>
                                  <h1 class=' -home' style='font-size:12em;color:#EC790C'></h1>
                                  <h2 style='margin-top: 0;color:#EC790C'>Contres Indications</h2>
                                  <br>
                                  
                                </center>" .
                $cis
                . "</div>
                            <div class='bhoechie-tab-content'>
                                <center>
                                  <h1 class=' -cutlery' style='font-size:12em;color:#EC790C'></h1>
                                  <h2 style='margin-top: 0;color:#EC790C'>Effets indésirables</h2>
                                  <br>
                                  
                                </center>
                                <ul class='list-group list-group-flush'>" .
                $effets
                . "</ul>                     
                            </div>
                        </div>                
                        </div>

                    </div>


                    </div>
                    
                    <script src='http://localhost:8000/bddm/js/jquery.js'></script>   
                    <script src='http://localhost:8000/bddm/js/bootstrap.js'></script>
                    <script src='http://localhost:8000/bddm/js/jquery-ui.js'></script> 
                    <script type='application/javascript' charset='utf8' src='https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js'></script>
                    <script type='application/javascript' charset='utf8' src='https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js'></script>
                    <script type='application/javascript' src='http://localhost:8000/bddm/js/adminlte.js'></script>
                    <script src='http://localhost:8000/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js'></script>
                    <script type='application/javascript' src='http://localhost:8000/bddm/js/handle_monographie.js'></script>
                </body>

            </html>";
            // Write the contents back to the file
            file_put_contents($myFile, $current);
            fclose($fh);
        }
        $end_time = microtime(true);
        $time = ($end_time - $start_time) / 60;

        return "Process took " . number_format(microtime(true) - $start_time, 2) . " seconds.";
    }

    protected function getSP($id)
    {
        return DB::table('sp_specialite')
            ->leftJoin('spcph_specialite_classeph', 'sp_specialite.sp_code_sq_pk', 'spcph_specialite_classeph.SPCPH_SP_CODE_FK_PK')
            ->leftJoin('cph_classepharmther', 'cph_classepharmther.CPH_CODE_PK', 'spcph_specialite_classeph.SPCPH_CPH_CODE_FK_PK')
            ->where('sp_specialite.sp_code_sq_pk', $id)
            ->get();
    }
    /**
     * retourne les médicaments theriaque equi au medic algérien recherché
     *
     * @return void
     * @author 
     */
    private function getMedicamentsEquiv($sp_alg)
    {

        // Get DCI(s) from ALG SP
        $dci = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->join('pre_presentation', 'pre_presentation.PRE_SP_CODE_FK', 'sp_specialite.SP_CODE_SQ_PK')
            ->where('sp_specialite.SP_CODE_SQ_PK', $sp_alg['0']->SP_CODE_SQ_PK)
            ->select(DB::raw("sac_subactive.SAC_CODE_SQ_PK  as dci "), 'pre_presentation.PRE_CDF_UP_CODE_FK', "sp_specialite.sp_dose")
            ->get();
        // Debugbar::info($dci);
        $res = collect($dci)->map(function ($item, $key) {
            return $item->dci;
        });

        $dcis_imp = implode(",", $res->toArray());
        // Debugbar::info($dcis_imp); 
        $long = count($res); // nbre de dci du sp alg

        if (count($res) == 0)
            return array(
                'medicament' => "Aucun médicament Equivalent trouvé",
            );

        // Récupérer les specialites avec le m DCI que le médicaments Algérien    
        $sps = DB::table('sp_specialite')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->where('sp_specialite.SP_ALGERIE', '=', null)
            ->whereIn('COSAC_SAC_CODE_FK_PK', $res)
            ->select('sp_specialite.SP_CODE_SQ_PK')
            ->get();
        $sps_ID = collect($sps)->map(function ($item, $key) {
            return $item->SP_CODE_SQ_PK;
        });
        // $sps_ID = implode(',',$sps->toArray());    
        // Une request pour récupérer tt les DCIS ASSOCIées avec les spécialités récupérées en haut
        $sps = DB::table('sp_specialite')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->leftJoin('pre_presentation', 'pre_presentation.PRE_SP_CODE_FK', 'sp_specialite.SP_CODE_SQ_PK')
            ->where('sp_specialite.SP_ALGERIE', '=', null)
            ->whereIn('sp_specialite.SP_CODE_SQ_PK', $sps_ID)
            ->groupBy('sp_specialite.SP_CODE_SQ_PK')
            ->havingRaw('COUNT(cosac_compo_subact.COSAC_SAC_CODE_FK_PK)=' . $long) // filter les sp qui ont seulement le m nbre de dci que sp alg
            ->select(DB::raw("GROUP_CONCAT(cosac_compo_subact.COSAC_SAC_CODE_FK_PK SEPARATOR ',') as p"), 'sp_specialite.SP_CODE_SQ_PK', "sp_specialite.SP_NOM", "pre_presentation.PRE_CDF_UP_CODE_FK")
            ->get();
        // return $sps;
        // Debugbar::info("Filter les médicaments par les m DCIS: ");    
        // Debugbar::info($sps);    

        if (count($sps) == '0')
            return array(
                'medicament' => "Aucun médicament Equivalent trouvé",
            );
        // Debugbar::info("Le code Unité du médicament ALG : ".$dci['0']->PRE_CDF_UP_CODE_FK);
        $sps = collect($sps)->map(function ($item, $key) use ($dci, $dcis_imp) {
            // Debugbar::info($item->p."  =>  ".$dcis_imp);
            if ($item->PRE_CDF_UP_CODE_FK == $dci['0']->PRE_CDF_UP_CODE_FK) {
                return $item;
            }
        });

        // return $sps;
        // GET DCI(S) NAME
        $dci_alg = DB::table('sac_subactive')
            ->join('cosac_compo_subact', 'cosac_compo_subact.COSAC_SAC_CODE_FK_PK', 'sac_subactive.SAC_CODE_SQ_PK')
            ->join('sp_specialite', 'cosac_compo_subact.COSAC_SP_CODE_FK_PK', 'sp_specialite.SP_CODE_SQ_PK')
            ->select('sp_specialite.SP_CODE_SQ_PK', 'sp_specialite.SP_NOM', DB::raw("CONCAT(sac_subactive.SAC_NOM , ' ',cosac_compo_subact.COSAC_DOSAGE) AS dci"))
            ->toSql();
        $dci_alg = DB::table(DB::raw(" ({$dci_alg}) as p"))
            ->where('p.SP_CODE_SQ_PK', $sp_alg['0']->SP_CODE_SQ_PK)
            ->select(DB::raw(" GROUP_CONCAT(p.dci SEPARATOR '/') as dci"))
            ->get();
        // END GET DCI(S) NAME
        // Debugbar::info("Le resultat final :");
        // Debugbar::info($sps);
        return  [
            'sps'        => $sps,
            'dci_alg'    => $dci_alg['0']->dci,
            'medicament' => $sp_alg['0']->SP_NOM,
        ];
    }
    /**
     * show suggestion of drugs
     *
     * @return Drug(s)
     * @author Kazi Aouel Sid Ahmed
     */
    public function postMonographie($medicament)
    {
    }
}
