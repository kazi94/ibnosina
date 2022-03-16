<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '<>', '1')->get();
        $roles = Role::all();
        // or 
        //$roles = DB::table('roles')->get();

        return view('admin.user.show', compact('users', 'roles'));
    }

    public function getProfile($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {

        $user = new User;
        $user->matricule = $request->matricule;
        $user->name = ucfirst($request->name); //Upper the first char
        $user->prenom = ucfirst($request->prenom);
        $user->service = $request->service;
        $user->hopital = $request->hopital;
        $user->grade = ucfirst($request->grade);
        $user->email = $request->email;
        $user->date_naissance = $request->date_naissance;
        $user->specialite = $request->specialite;
        $user->is_admin = $request->admin;
        $user->role_id = $request->role_id;
        $user->password = bcrypt($request->password);
        $user->save();

        //redirect into users list view
        return redirect(route('user.index'))->with('message', 'Utilisateur créer avec succées !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == 1)
            return view('errors.500');
        else {

            $user = User::find($id);

            $roles = Role::all();
            if (\Request::ajax()) {
                return response()->json($user, 200);
            }
            return view('admin.user.edit', compact('user', 'roles'));
        }
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

        $user = User::find($id);

        $user->matricule      = $request->matricule;
        $user->name           = $request->name;
        $user->prenom         = $request->prenom;
        $user->date_naissance = $request->date_naissance;
        $user->grade          = $request->grade;
        $user->service          = $request->service;
        $user->specialite     = $request->specialite;
        $user->is_admin       = $request->admin;
        $user->email          = $request->email;
        $user->role_id        = $request->role_id;
        $user->password       = bcrypt($request->password);

        $user->save();

        //associate and persist id user to id roles in table 'user_role'
        //$user->roles->sync($request->role_id);

        //redirect into users list view
        return redirect(route('user.index'))->with('message', 'Utilisateur Modifier avec succées !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function getUser($id)
    {
        $user = User::find($id);

        return response()->json($user, 200);
    }
}
