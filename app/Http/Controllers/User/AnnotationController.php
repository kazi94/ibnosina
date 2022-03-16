<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Annotation;
use Auth;

class AnnotationController extends Controller
{
    public function store(Request $request)
    {


        $ann = new Annotation;
        $ann->date              = $request->date;
        $ann->commentaire       = $request->commentaire;
        $ann->domaine           = $request->domaine;
        $ann->lecture           = $request->lecture;
        if (isset($request->file)) {
            $extension = $request->file('file')->extension();
            $fileNameToStore = 'sounds/annotations/' . time() . '.' . $extension;
            $path = $request->file('file')->storeAs('/public/sounds/annotations', time() . "." . $extension);
            $ann->audio             = $fileNameToStore;
        }
        $ann->user_id           = Auth::user()->id;
        $ann->pat_id            = $request->patient_id;
        $ann = $this->getSubject($request, $ann);
        $ann->save();
        return redirect()->back()->with('message', 'Annotation ajoutée avec succés !');
    }

    private function getSubject($req, $ann)
    {
        switch ($req->object_type) {
            case 'hospitalisation':
                $ann->sujet             = "Hospitalisation";
                $ann->hospitalisation_id   = $req->object_id;
                break;
            case 'consultation':
                $ann->sujet             = "Consultation";
                $ann->consultation_id   = $req->object_id;
                break;
            case 'prescription':
                $ann->sujet             = "Prescription";
                $ann->prescription_id   = $req->object_id;
                break;
            case 'patient':
                $ann->sujet             = "Patient";
                $ann->patient_id   = $req->object_id;
                break;
            case 'phyto':
                $ann->sujet             = "Phytothérapie";
                $ann->phyto_id   = $req->object_id;
                break;
            case 'act':
                $ann->sujet             = "Act Médicale";
                $ann->act_id   = $req->object_id;
                break;
            case 'bilan':
                $ann->sujet             = "Examen";
                $ann->examen_id   = $req->object_id;
                break;
            case 'traitement':
                $ann->sujet             = "Traitement Chronique";
                $ann->chron_id   = $req->object_id;
                break;
            case 'edu':
                $ann->sujet             = "Education thérapeutique";
                $ann->education_id   = $req->object_id;
                break;
            case 'observance':
                $ann->sujet             = "Observance";
                $ann->obs_id   = $req->object_id;
                break;
            case 'annotation':
                $ann->sujet             = "Annotation";
                $ann->annotation_id   = $req->object_id;
                break;
            case 'auto':
                $ann->sujet             = "Automédication";
                $ann->automedication_id   = $req->object_id;
                break;

            default:
                # code...
                break;
        }

        return $ann;
    }
}
