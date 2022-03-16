<?php

namespace App\Http\Controllers\Chimio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelsChimio\Protocole;
use App\ModelsChimio\Pathologies;
use App\ModelsChimio\StadeChimio;
use DB;

class MaladieController extends Controller
{
    public function blank()
    {
        // Only authenticated users may enter...
        return view('chimio/blank');
    }
    public function addProtocole()
    {
        return view('chimio.addProtocole');
    }

    public function index()
    {
        //récupérer tt les stade
        $stades = StadeChimio::All();
        $stade = DB::table('pathologies_stade')->get();
        $stade = $stade->unique('pathologies_id');
        $col2 = collect();
        foreach ($stade as $ss) {
            //$pathologie = Pathologies::find($s->pathologies_id);
            $f = DB::table('pathologies_stade')
                ->where('pathologies_id', $ss->pathologies_id)
                ->get();
            $col2->put($ss->pathologies_id, $f);
        }

        //récupérer tt les protocoles
        $protocoles =  Protocole::All();
        $sp = DB::table('pathologies_protocole')->get();
        $sp = $sp->unique('pathologies_id');
        //dd($sp);
        $col = collect();
        foreach ($sp as $s) {
            //$pathologie = Pathologies::find($s->pathologies_id);
            $protocole = DB::table('pathologies_protocole')
                ->where('pathologies_id', $s->pathologies_id)
                ->get();
            $col->put($s->pathologies_id, $protocole);
        }
        //dd($col2);
        return view('chimio/listMaladie', compact('protocoles', 'col', 'col2'));
    }
    public function create()
    {
        //       
    }

    public function store(Request $request)
    {
        $nomM = $request->input('nomM');

        if ($nomM) {
            $pathologie = Pathologies::where('pathologie', $nomM)->first();
            $pathologie->protocoles()->detach();
            $pathologie->stades()->detach();
        }
        $protocoles = $request->input('protocoles');
        $pathologieNom = strtoupper($request->input('nom'));
        //stade
        $stades = $request->input('tagss');
        $array = explode(',',  $stades);
        //replir table stade chimio si le stade n'existe pas
        foreach ($array as $a) {
            $aa = StadeChimio::where('stade_chimios_id', $a)->get();
            if ($aa->isEmpty()) {
                $stade =  new StadeChimio;
                $stade->stade_chimios_id = strtoupper($a);
                $stade->save();
            }
        }

        $existe = Pathologies::where('pathologie', $pathologieNom)->get();
        //TEST si la pathoslogie existe deja
        if ($existe->isEmpty()) {
            $pathologies = new Pathologies;
            //générer un id unique
            $rand = substr(md5(microtime()), rand(0, 26), 5);
            $pathologies->id = strtoupper($rand);
            $pathologies->pathologie = $pathologieNom;
            $pathologies->save();
            //Inserer dans la table pivot
            //passé un tableau de id a la fonction attach()
            $pathologies->protocoles()->attach($protocoles);
            $pathologies->stades()->attach($array);
        } else {
            $existe[0]->protocoles()->attach($protocoles);
            $existe[0]->stades()->attach($array);
        }

        //return redirect()->route("listMaladie.index")->with('message','Maladie ajouté');
        return 'ok';
    }


    public function show()
    {
    }
    public function edit(Request $request)
    {
        $nomM = $request->input('nomM');
        //Pathologies::destroy('');



        return response()->json(['success' => true]);
    }

    public function getPathologieNom()
    {
        $result = array();
        $sp1 = DB::table('pathologies')
            ->where('pathologies.pathologie', 'LIKE', '%' . $_POST['phrase'] . '%')
            ->limit(15)
            ->get();
        $result =  $sp1;
        return response()->json($result);
    }

    public function destroy($id)
    {
        DB::table('pathologies_protocole')->where('pathologies_id', $id)->delete();
        DB::table('pathologies_stade')->where('pathologies_id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function getDetailPathologie($id)
    {
        $pathologie = Pathologies::find($id);
        $protocoles = $pathologie->protocoles()->get()->toArray();



        return response()->json($protocoles);
    }
    function getDetailPathologieTag($id)
    {
        $pathologie = Pathologies::find($id);
        //$stades = $pathologie->stades()->get()->toArray(); camarche pas je sais pas prk !!!
        $stades = DB::table('pathologies_stade')
            ->where('pathologies_id', $pathologie->id)
            ->pluck('stade_chimios_id')
            ->toArray();

        $r = implode(",", $stades);
        return $r;
        //return response()->json($stades);
    }

    public function getProtocolePathologie(Request $request)
    {
        $path = $request->input('maladie_id');
        $result = array();
        $protocoles = Pathologies::find($path)->protocoles()->get();
        $result =  $protocoles;
        if ($result->isEmpty()) {
            return 0;
        }

        $stades = DB::table('pathologies_stade')
            ->where('pathologies_id', $path)
            ->pluck('stade_chimios_id')
            ->toArray();

        $array = array(
            $result,
            $stades,
        );

        return response()->json($array);
    }

    function getStadesPathologie(Request $request)
    {
        /* $id = $request->input('maladie_id');
        $stades = DB::table('pathologies_stade')
              ->where('pathologies_id',$id)   
              ->pluck('stade_chimios_id')
              ->toArray();

        return response()->json($stades);*/
        return 'ok';
    }

    function getTag()
    {
        $tags = StadeChimio::All()->pluck('stade_chimios_id')->toArray();
        return response($tags);
    }
}
