<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegleEduPatient extends Model
{
    public function PatientAEduc()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
    public function RegleEducConcerne()
    {
        return $this->belongsTo('App\Models\Education', 'regle_id');
    }
    public function PrescEducConcerne()
    {
        return $this->belongsTo('App\Models\Prescription', 'prescription_id');
    }
}
