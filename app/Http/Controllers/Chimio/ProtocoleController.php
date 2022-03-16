<?php

namespace App\Http\Controllers\Chimio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ModelsChimio\Protocole;
use App\ModelsChimio\unite;
use App\ModelsChimio\Sequencetype;
use App\ModelsChimio\Medicament_sequencetype;
use DB;
use Validator;
use App\Rules\NbrcureRule;
use App\Rules\SeqRule;
use App\Rules\MedicRule;
use App\Rules\PosRule;
use App\Rules\MedicDupliq;
use Illuminate\Support\Facades\Auth;


class ProtocoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unites = unite::all();
        return view('chimio.addProtocole',compact('unites'));
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
        $messages = [// Ajout des type de messages d'erreurs à afficher
            'distinct' => "Le champs Médicament DCI est dupliqué",
            ];
        $validator = Validator::make($request->all(), [
            'nom_protocole'=>'required',
            'cure_min'=>'required|numeric',
            'cure_max'=>['required', new NbrcureRule($request->input('cure_min'))],
            'intervalle'=>'required|numeric',
            'med_sp_id_prem' => [ new MedicRule()],
            'med_sp_id_trait' => [ new MedicRule(), new MedicDupliq($request->input('med_sp_id_prem'))],
            'seq_j' => ['required', new SeqRule()],
            'pos_trait' =>['required', new PosRule()],
            'pos_prem' =>['required', new PosRule()],
        ]);
        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()],422);
                            
        $trait_form = $request->input('trait_form');

        $nbr_seq = $request->input('nbr_sequence');
        $medic_prem = $request->input('med_sp_id_prem');
        $medic_trait = $request->input('med_sp_id_trait');

        $pos_prem = $request->input('pos_prem');
        $pos_trait = $request->input('pos_trait');

        $voie_prem = $request->input('voie_prem');
        $voie_trait = $request->input('voie_trait');

        $u1_trait = $request->input('u1_trait');
        $u2_trait = $request->input('u2_trait');
        $u3_trait = $request->input('u3_trait');

        $u1_prem = $request->input('u1_prem');
        $u2_prem = $request->input('u2_prem');

        
        $seq_j = $request->input('seq_j');

        $solvant_prem = $request->input('solvant_prem');
        $solvant_trait = $request->input('solvant_trait');
        $commentairedci_prem = $request->input('commentairedci_prem');
        $commentairedci_trait = $request->input('commentairedci_trait');
        
        $protocole = new Protocole;
        $protocole->nbrcure_min = $request->input('cure_min');
        $protocole->nbrcure_max = $request->input('cure_max');
        $protocole->user_id = Auth::user()->id;
        $protocole->intervalle_cure = $request->input('intervalle');
        $protocole->remarque = $request->input('remarque');
        $protocole->nom = strtoupper($request->input('nom_protocole'));
        $protocole->nbr_sequence  = $request->input('nbr_sequence');

        $protocole->save();



        for ($seq=1; $seq <= $nbr_seq; $seq++) {
            $s = "seq_".$seq;
            $sequence = new Sequencetype;
            //$sequence->jour = $request->input($s);
            $sequence->jour = $seq_j[($seq-1)];
            $protocole->sequencetype()->save($sequence);


            $chekp = "prem_seq_".$seq;
            $inptp = $request->input($chekp);

            

            for ($prem=0; $prem < count($medic_prem); $prem++) {
                
                if($inptp[$prem]!=0){
                    $med_seq = new Medicament_sequencetype;
                    $med_seq->sp_id = $medic_prem[$prem];
                    $med_seq->posologie = $pos_prem[$prem];
                    $med_seq->voie = $voie_prem[$prem];
                    $med_seq->type = "prem";
                    $med_seq->u1 = $u1_prem[$prem];
                    $med_seq->u2 = $u2_prem[$prem];
                    $med_seq->solvant = $solvant_prem[$prem];
                    $med_seq->commentaire = $commentairedci_prem[$prem];
    
                    $sequence->medicament()->save($med_seq);
                }
            }

      /*      $inpt = array();
            array_push($stack, "apple", "raspberry");
            in_array ( $val, $array_name ,$mode );  */
            
            $chek = "trait_seq_".$seq;
            $inpt = $request->input($chek);
            

            for ($trait=0; $trait < count($medic_trait); $trait++) {

                    if($inpt[$trait]!=0){
                        
                        $med_seq = new Medicament_sequencetype;
                        $med_seq->sp_id = $medic_trait[$trait];
                        $med_seq->posologie = $pos_trait[$trait];
                        $med_seq->voie = $voie_trait[$trait];
                        $med_seq->type = "trait";
                        $med_seq->u1 = $u1_trait[$trait];
                        $med_seq->u2 = $u2_trait[$trait];
                        $med_seq->u3 = $u3_trait[$trait];
                        $med_seq->solvant = $solvant_trait[$trait];
                        $med_seq->commentaire = $commentairedci_trait[$trait];
        
                        $sequence->medicament()->save($med_seq);
                    }
            }
        }
    } 
        
    

    public function add(){
        return view('chimio.addProtocole');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {       
        //récupérer tt les protocoles
        $protocole =  Protocole::All();
        //faire une redirection vers list protocole et passé le résultat de la requette
        return view('chimio/listProtocole')->withProtocole($protocole);
    }
   /**
    * récupérer les informations du protocole
    * @param  id $id entier du protocole
    * @return null     
    */
    public function showDetail($id){
        //récupérer le protocole
        $protocole = Protocole::find($id);
        //récupérer toutes les séquences du protocole
        $sequence = Sequencetype::where('protocole_id',$protocole->id)->get();
        //récupérer toutes les médicaments de toutes les séquences
       // déclarer une collection vide
        $collection = collect();
        //parcourir toutes les séquences
        foreach ($sequence as $seq) {
            $medicament = Medicament_sequencetype::where('sequencetype_id',$seq->id)->get();
            //dd($medicament);
            $collection = $collection->concat($medicament);
        }
        //$collection = $collection->sortBy('sequencetype_id');
        $unique = $collection->unique('sp_id');
        //divisé la collection en 2 les médicament et les traitements
        $premedicament = collect();
        $traitement = collect(); 
        foreach ($unique as $u) {
            if ($u->type == "prem") {
                $premedicament->put($u->id,$u);
            } else {
                $traitement->put($u->id,$u);
            }
            
        }

        //dd($collection);

       return view('chimio/detailProtocole',compact('protocole','sequence','collection','premedicament','traitement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Protocole::destroy($id);
        return response()->json(['success'=>true]);
    }

    public function findById($id){
        $result = array();
        $protocole = Protocole::find($id);
        $result =  $protocole; 

        return response()->json($result);
    }
}
