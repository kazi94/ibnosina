<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regle;
use DB;
use Validator;
class SpecialiteController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
// $produits= Produitalimentaire::all();
// $interactions = Interaction::all();
//redirect table to show.blade
return view ('admin.specialite.create');
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
}
public function show()
{
}
/**
 * Associate units to there specific drugs
 *
 * @return void
 * @author __KaziWhite**__SALAF4_WebDev**
 **/
public function storeUnit(Request $request)
{

    for ($i=0; $i < count($request->sp); $i++) 
    {

        if (isset($request->unite[$i]))
        {
            $result = DB::table('pre_presentation')->where(
                'pre_sp_code_fk' , $request->sp[$i]
            )->update([
                'pre_cdf_up_code_fk' => $request->unite[$i]
            ]);

        } 

    }

    return $result;
}
/**
* Store a newly drugs specialite.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    $messages = [
        'required' => "Le champs :attribute est obligatoire",
        'unique'   => "Le médicament spécialité est dèja ajouté !",
        ];
    $validator = Validator::make($request->all(), 
        ['sp_nom'  => 'required|unique:sp_specialite|string'], $messages);

    if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput(); 

    $id = DB::table('sp_specialite')->insertGetId([
            'SP_NOM'=> $request->sp_nom,
            'sp_algerie'=> 1]);
    DB::table('pre_presentation')->insert([
            "pre_code_pk" => $id,
            "pre_cdf_up_code_fk" => $request->unite,
            "pre_sp_code_fk" =>$id]);
    DB::table('spvo_specialite_voie')->insert([
            "spvo_cdf_vo_code_fk_pk" => $request->voie,
            "spvo_sp_code_fk_pk" =>$id]);
    if (count($request->med_sp_id) > 0)
        foreach ($request->med_sp_id as $dci_id) {
            if ($dci_id)
                DB::table('cosac_compo_subact')->insert([
                    "COSAC_SAC_CODE_FK_pk" => $dci_id,
                    "COSAC_SP_CODE_FK_pk" => $id,
                    "COSAC_COMPO_NUM_PK" => 1]);
        }
return view ('admin.specialite.create');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
    {
        DB::table('sp_specialite')->where('SP_CODE_SQ_PK',  $id)->delete();
        return redirect(route('specialite.index'))->with('message' ,'Médicament supprimé avec succés !');
    }
public function update(Request $request, $id)
    {

        DB::table('sp_specialite')->where('SP_CODE_SQ_PK',              $request->sp_id)->update([
                'SP_NOM'                 => $request->sp_nom ]);

        DB::table('pre_presentation')->where("pre_sp_code_fk" ,         $request->sp_id)->update([
                "pre_cdf_up_code_fk"     => $request->unite  ]);

        DB::table('spvo_specialite_voie')->where('spvo_sp_code_fk_pk' , $request->sp_id)->update([
                "spvo_cdf_vo_code_fk_pk" => $request->voie   ]);

        DB::table('cosac_compo_subact')->where('COSAC_SP_CODE_FK_pk' ,  $request->sp_id)->delete();

        if (count($request->medicament_dci_id) > 0) {
            foreach ($request->medicament_dci_id as $dci_id) {
                if (isset($dci_id)) {                    
                    DB::table('cosac_compo_subact')->insert([
                        "COSAC_SAC_CODE_FK_pk" => $dci_id,
                        "COSAC_SP_CODE_FK_pk"  => $request->sp_id,
                        "COSAC_COMPO_NUM_PK"   => 1]);          
                 }   
            }        
        }

        return view ('admin.specialite.create');
    }

    /**
     * return edit specialite view
     *
     * @return void
     * @author 
     **/
    public function edit($id) {
        $sp = DB::table('sp_specialite')
        ->join('pre_presentation','pre_presentation.pre_sp_code_fk','sp_specialite.SP_CODE_SQ_PK')
        ->join('spvo_specialite_voie','spvo_specialite_voie.spvo_sp_code_fk_pk','sp_specialite.SP_CODE_SQ_PK')
        ->where('SP_CODE_SQ_PK' , $id)
        ->get();
        return 
        (
            ($sp != null && count($sp) > 0) ? 
            view('admin.specialite.edit' , compact('sp')) : 
            redirect()->back()->with('message' , 'Impossible de renseigner le DCI , Veuillez d\'abord renseigner la voie et la forme associé au médicament séléctionner !')
        );
    }
}