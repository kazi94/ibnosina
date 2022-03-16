<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserEx;
use App\Compte;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserEx;
use DB;

class UserExController extends Controller
{
    
    public function index()
    {
        $users = DB::table('medecins')->get();

        return view ('admin.userEx.show' , compact('users'));
    }

   
    public function create()
    {
        return view ('admin.userEx.create');
    }
   

    public function store(StoreUserEx $request)
    {

        $user = new UserEx;
        $user->nom= ucfirst($request->name);//Upper the first char
        $user->prenom= ucfirst($request->prenom);
        $user->email= $request->email;
        $user->date_naissance= $request->date_naissance;
        $user->password= bcrypt($request->password);
        $user->save();

        //redirect into users list view
        $request->session()->flash('alert-success', 'Compte créer avec succées !');
        return redirect(route('userEx.index'));
    }

    public function update(Request $request, $id)
    {

        $user =userEx::find($request->id);

        $emails_comptes = Compte::all()->pluck('email')->toArray();
        $emails_users = UserEx::where('id','<>',$request->id)->pluck('email')->toArray();
        $emails = array_merge($emails_comptes,$emails_users);
        if(in_array($request->email,$emails)){
            // $request->session()->flash('alert-danger', 'email existe deja !');
            $request->session()->flash('alert-danger', 'email est déja pris par un patient ou un utilisateur externe !');
            return redirect(route('userEx.index'));
        }

        $validator = \Validator::make($request->all(), [
            "email"      => "required|email|string|unique:users_externes,email,".$user->id ,
            "password"   => "required|min:6"
        ],
        [
            'unique'   => 'cette email est déja pris par un patient ou un utilisateur externe !',
            'required' => 'le champ :attribute est obligatoire',
            'min'      => 'le champ :attribute exige au minimum :min caracteres'
        ]);
        
        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            foreach ($error as $er ) {
                $request->session()->flash('alert-danger', $er);
            }
            
        }else{
            
            $user->email= $request->email;
            $user->password= bcrypt($request->password); 
            $user->save();
            
            $request->session()->flash('alert-success', 'Compte modifier avec succées !');
        }
        
        return redirect(route('userEx.index'));
    }
    

    public function destroy($id)
    {
        UserEx::where('id',$id)->delete();

        return redirect()->back();
    }
}
