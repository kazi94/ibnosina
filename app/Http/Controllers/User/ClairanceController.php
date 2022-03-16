<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Clairance;


class ClairanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('widgets.calculator.clairance');
    }

    /**
     * Calcule Clairance
     *
     * @return \Illuminate\Http\Response
     */
    public function calculClairance(Request $req)
    {
        $clairance = new Clairance();
        $create = $clairance->convertToMicroMol($req->creat , $req->unit);
        $result = $clairance->calcul_clr($req->taille, $req->sexe, $req->poids, $req->age, $create, $req->enceinte);
        $method = $clairance->getMethod($req->age);
        $mdrd = $clairance->formuleMDRD($req->sexe, $req->age, $req->creat);
        $age = $req->age;

        return response()->json([
            'result' => $result,
            'method' => $method,
            'mdrd' => $mdrd,
            'age' => $age
        ], 200);
    }


}
