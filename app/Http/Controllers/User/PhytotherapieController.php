<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Phytotherapie;
use App\Http\Requests\StorePhytotherapie;
use Validator;
use Auth;
use DB;

class PhytotherapieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhytotherapie $request)
    {
        $id = array();
        if (Auth::user()->cant('phytotherapies.create'))
            return redirect()->back()->with('message', 'Action non autorisée !');

        $phyto                        = new Phytotherapie;
        $phyto->user_id               = $request->user()->id;
        $phyto->patient_id            = $request->patient_id;
        $phyto->produitalimentaire_id = $request->produitalimentaire_id;
        $phyto->date_phyto            = now();
        $phyto->frequence             = $request->frequence;
        $phyto->frequence_date        = $request->frequence_date;
        $phyto->used_on        = $request->used_on;
        $phyto->save();

        return redirect()->back()->with(['message' => 'Produit alimentaire ajouté avec succés !', 'tab' => 'tab_6']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('phytotherapies.delete'))
            return redirect()->back()->with('message', 'Action non autorisée !');
        //fetch row to delete
        $deleted = Phytotherapie::where('id', $id)->delete();
        // reset auto increment to the last id before deleted
        DB::update("ALTER TABLE phytotherapies AUTO_INCREMENT = 1;");
        return $deleted ?  response()->json(['response' => 'success', 'msg' => 'Produit alimentaire supprimé avec succés !'], 200) : 'Erreur dans la suppression';
    }
}
