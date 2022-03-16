<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operation_chirugicale;

class Operation_chirugicaleController extends Controller
{
    public function show($request)
    {
        $operation = new Operation_chirugicale;
        $operation->nom = $request;
        $operation->save();
        return response()->json($operation->id, 201);
    }
    public function destroy($id)
    {
    }

    public function update(Request $request, $id)
    {
    }
}
