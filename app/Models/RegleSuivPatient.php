<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RegleSuivPatient extends Model
{
    public function PatientASuivre() {
    	return $this->belongsTo('App\Models\Patient','patient_id');
    }
    public function RegleSuiviConcerne() {
    	return $this->belongsTo('App\Models\Suivi','regle_id');
    }
}
