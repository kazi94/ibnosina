<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Compte;
use App\UserEx;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompte;
use DB;
use Crypt;

class CompteController extends Controller
{

    public function index()
    {
        $comptes = Compte::all();

        $patients = Patient::all();


        return view('admin.compte.show', compact('comptes', 'patients'));
    }


    public function create()
    {
        $comptes = Compte::all();
        $comptes_id = array();
        foreach ($comptes as $c) {

            array_push($comptes_id, $c->patient_id);
        }

        $users = DB::table('patients')
            ->select('id', 'nom', 'prenom')
            ->whereNotIn('id', $comptes_id)
            ->get();


        return view('admin.compte.create', compact('users'));
    }


    public function store(StoreCompte $request)
    {

        $patient = DB::table('patients')->select('nom', 'prenom', 'num_tel_1')
            ->where('id', $request->patient_id)
            ->first();
        $nom = ucwords($patient->nom . " " . $patient->prenom);
        $code = Str::random(16);

        $compte = new Compte;
        $compte->code = $code;
        $compte->name = $nom;
        if ($request->email != null) {
            $compte->email = strtolower($request->email);
        }
        $compte->patient_id = $request->patient_id;

        $compte->tel = $patient->num_tel_1;

        $compte->password = bcrypt($request->password);
        $compte->save();

        //redirect into users list view
        $request->session()->flash('alert-success', 'Compte créer avec succées !');
        return redirect(route('compte.index'));
    }



    public function destroy($id)
    {
        Compte::where('id', $id)->delete();

        return redirect()->back();
    }

    public function update(Request $request)
    {

        $compte = Compte::find($request->id);

        $validator = \Validator::make(
            $request->all(),
            [
                "email"      => "required|email|string|unique:comptes,email," . $compte->id,
                "password"   => "required|min:6",
                "tel"        => ['required', 'max:10', 'regex:/(05|06|07)[0-9]{8}/']
            ],
            [
                'unique'   => 'cette email est déja pris par un patient ou un utilisateur externe !',
                'required' => 'le champ :attribute est obligatoire',
                'min'      => 'le champ :attribute exige au minimum :min caracteres',
                'max'      => 'le champ :attribute exige au maximum :max caracteres',
                'regex'    => 'le champ :attribute exige un numero valide'
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            foreach ($error as $er) {
                $request->session()->flash('alert-danger', $er);
            }
        } else {


            $compte->email = strtolower($request->email);
            $compte->password = bcrypt($request->password);
            if ($request->tel != null) {
                $compte->tel = $request->tel;
                DB::table('patients')->where('id', '=', $compte->patient_id)->update(['num_tel_1' => $request->tel]);
            }
            $compte->save();

            $request->session()->flash('alert-success', 'Compte modifier avec succées !');
        }

        return redirect(route('compte.index'));
    }
}
