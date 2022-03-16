<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation;


class HospitalisationController extends Controller
{

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getById($id): JsonResponse
    {
        return response()->json(Hospitalisation::findOrFail($id), 200);
    }

}
