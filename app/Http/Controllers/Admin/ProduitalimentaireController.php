<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produitalimentaire;
use App\Models\Interaction;
use DB;
use App\Http\Requests\StoreProduit;

class ProduitalimentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produitalimentaire::orderBy('created_at', 'desc')->get();

        $interactions = Interaction::all();

        //redirect table to show.blade
        return view('admin.phyto.show', compact('produits', 'interactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //redirect to create.blade
        return view('admin.phyto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduit $request)
    {

        // dd($request->all());
        if ($request->isMethod('POST')) {

            $produit = new Produitalimentaire;
            $produit->produit_naturel_fr    = $request->produit_naturel_fr;
            $produit->produit_naturel_latin = $request->produit_naturel_latin;
            $produit->partie_active = $request->partie_active;
            $produit->mode_preparation = $request->mode_preparation;

            if ($request->has('produits_arabe'))
                $produit->produits_arabe = join("،", $request->produits_arabe);

            $produit->save();

            $id = array();
            for ($i = 0; $i < count($request->medicament_dci_id); $i++) { //insert interactions
                if ($request->medicament_dci_id[$i] != "null")
                    $id[$i] = DB::table('interactions')->insertGetId(
                        [
                            'type_effet'            => $request->type_effet[$i],
                            'niveau'                  => $request->niveau[$i],
                            'effet_interaction'          => $request->effet_interaction[$i],
                            'indication'                => $request->indication[$i],
                            'effet_pharmaco'            => $request->effet_pharmaco[$i],
                            'recommendation'            => $request->recommendation[$i],
                            'sac_subactive_id'          => $request->medicament_dci_id[$i],
                            'produitalimentaire_id'     =>  $produit->id
                        ]
                    );
            }

            //$produit->interactions()->sync($id); // syncing foreign keys in intermediate table : interaction_produitalimentaire
            //dd($id);
            return redirect(route('produit.index'))->with('message', 'Insertion effectuée avec succées !');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get row from produit alimentaire table
        $produit = Produitalimentaire::find($id);
        //$interactions = App\Produitalimentaire::find($id)->interactions;
        $interactions = DB::table('interactions')->select('type_effet')->distinct()->get();

        //get string    
        $str = $produit->produits_arabe;
        if ($str != "") {

            //split str into array

            $produits_arabe = explode("،", $str);
        } else {
            $produits_arabe = array();
        }
        //redirect to edit blade
        return view('admin.phyto.edit', compact('produit', 'produits_arabe', 'interactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduit $request, $id)
    {
        // return $request->all();

        if ($request->isMethod('PATCH')) {

            $produit = Produitalimentaire::find($id);
            $produit->produit_naturel_fr    = $request->produit_naturel_fr;
            $produit->produit_naturel_latin = $request->produit_naturel_latin;
            $produit->partie_active = $request->partie_active;
            $produit->mode_preparation = $request->mode_preparation;

            if ($request->has('produits_arabe'))
                $produit->produits_arabe = join("،", $request->produits_arabe);
            else $produit->produits_arabe = "";

            $produit->save();

            $produit->interactions()->delete();
            DB::update("ALTER TABLE interactions AUTO_INCREMENT = 1;");

            $id = array();
            if (isset($request->medicament_dci_id)) {
                for ($i = 0, $j = count($request->medicament_dci_id); $i < $j; $i++) { //insert into interactions
                    if (isset($request->medicament_dci_id[$i])) {
                        $id[$i] = DB::table('interactions')->insertGetId(
                            [
                                'type_effet'             => $request->type_effet[$i],
                                'effet_interaction'      => $request->effet_interaction[$i],
                                'niveau'                 => $request->niveau[$i],
                                'indication'                => $request->indication[$i],
                                'effet_pharmaco'            => $request->effet_pharmaco[$i],
                                'recommendation'            => $request->recommendation[$i],
                                'sac_subactive_id'          => $request->medicament_dci_id[$i],
                                'produitalimentaire_id'     =>  $produit->id
                            ]
                        );
                    }
                }
            }
            //$produit->interactions()->sync($id);                   

            return redirect(route('produit.index'))->with('message', 'Modification effectuée avec succées !');
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
        Produitalimentaire::where('id', $id)->delete();
        DB::update("ALTER TABLE produitalimentaires AUTO_INCREMENT = 1;");
        return redirect(route('produit.index'))->with('message', 'Produit alimentaire supprimé avec succés !');
    }

    /**
     * Function to return json fields from produit alimetaires table
     *
     * @return results
     * @author Kazi Aouel Sid Ahmed
     * @param phrase
     **/
    protected function getProduit($phrase)
    { // retourne produit_naturel_fr

        $result = DB::table('produitalimentaires')->select("produits_arabe", "produit_naturel_fr", 'id')->where('produit_naturel_fr', 'like', '%' . $phrase . '%')->get();

        return $result;
    }

    protected function getProduit1($phrase)
    { // retourne tout les produits naturel fr

        $result = DB::table('produitalimentaires')->select("produit_naturel_fr")->where('produit_naturel_fr',  $phrase)->get();

        return $result;
    }

    protected function getProduit_ar($phrase)
    { // retourne produit alimentaire arabe

        $result = DB::table('produitalimentaires')->select("produits_arabe", "produit_naturel_fr", 'id')->where('produits_arabe', 'like', '%' . $phrase . '%')->get();

        return $result;
    }
}
