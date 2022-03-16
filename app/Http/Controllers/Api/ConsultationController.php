<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Signe;


class ConsultationController extends Controller
{
    /**
     * get consultation
     */

    public function show($id)
    {
        return response()->json([
            'consultations' => Consultation::with('signes')->findOrFail($id),
            'signes' => Signe::all()
        ], 200);
    }
}
