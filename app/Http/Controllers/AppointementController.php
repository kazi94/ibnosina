<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use App\Models\Appointement;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointementController extends Controller
{
     /**
    * store New Patient add from calendar
    *
    * @return void
    * @author 
    **/
   public function storePatient(Request $request)
   {
          $patient = new Patient;
          $patient->nom = ucfirst($request->nom);
          $patient->prenom = ucfirst($request->prenom);
          $patient->date_naissance = $request->date_naissance;
          $patient->save();
          if ($patient) return response()->json([ 'p_id' => $patient->id]);
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('appointement');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request){
        
    $event             = new Appointement();
    $event->text       = strip_tags($request->text);
    $event->patient_id = $request->patient_id;
    $event->created_by = Auth::id();
    $event->type_rdv   = $request->type_rdv;
    $event->color      = self::random_color();
    $event->start_date = $request->start_date;
    $event->end_date   = $request->end_date;
    $event->save();
 
    return response()->json([
      "action" => "inserted",
      "tid"    => $event->id
    ]);
   }
 
   public function update($id, Request $request)
   {
       $event             = new Appointement;
       $event             = Appointement::find($id);
       $event->text       = strip_tags($request->text);
       $event->patient_id = $request->patient_id;
       $event->type_rdv   = $request->type_rdv;
       $event->start_date = $request->start_date;
       $event->end_date   = $request->end_date;
       $event->updated_by = Auth::id();
       $event->save();
 
       return response()->json([
           "action"=> "updated"
       ]);
   }
 
   public function destroy($id){
       $event = Appointement::find($id);
       $event->delete();
 
       return response()->json([
           "action"=> "deleted"
       ]);
   }

    public function show($id)
    { 
        if (Auth::user()->role->afficher_rdv == "on"){
          //Acces to appointements of users of the authenticated service user
          $appointements = Appointement::join('users','users.id','appointements.created_by')
            ->where('users.service',Auth::user()->service)
            ->select('appointements.*')
            ->get();
          foreach ($appointements as $key => $value) { // set readonly to external appointements users
            if ($value->created_by != Auth::id())
            $value->readonly =true;
          }
        }  
        else $appointements = Appointement::where('created_by',Auth::id())->get();

      //Returned Format should be : { value : '' , label : ''}
      $patients = Patient::select('id as value',DB::raw("CONCAT(nom, ' ',prenom) as label"))->get();
      // $patients->prepend([
      //   'id' => '0',
      //   'label' => ''
      // ]);
        return response()->json([
            "data"        => $appointements,
            "collections" => [
              "type" => $patients // add to list of lightbox
            ]
        ]);           
        
    }

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 127 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }
}
