<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unite;
use DB;
use Validator;

class UniteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sps = DB::table('sp_specialite')
            ->join('pre_presentation','pre_presentation.pre_sp_code_fk' ,'sp_specialite.SP_CODE_SQ_PK')
            ->whereNull('pre_presentation.pre_cdf_up_code_fk')
            ->orWhere('pre_presentation.pre_cdf_up_code_fk','dz1')
            ->select('pre_presentation.pre_cdf_up_code_fk' , 'sp_specialite.SP_NOM','sp_specialite.SP_CODE_SQ_PK')
            // ->distinct('pre_presentation.pre_cdf_up_code_fk')
            //  ->limit(500)
            ->toSql();
            return $sps;
        return view ('admin.unite.create1' , compact('sps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {

            $messages = ['required' => "Le champ :attribute est obligatoire" ];
            $validator = Validator::make($request->all(), ['unite_nom' => 'required'],$messages);
            if ($validator->fails()) return $validator->messages();
            
            $unite = new Unite;
            $unite->unite_nom =$request->unite_nom;
            $unite->save();
            DB::table('forme_unite')->insert(
            [
                'forme_id' => $request->forme ,
                'unite_id' =>$unite->id
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fetch row to delete
        Unite::where('id',$id)->delete();

        return redirect(route('unite.index'))->with('message' ,'Unité supprimé avec succés !');
    }
}
