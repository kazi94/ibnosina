<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Educationtherapeutique extends Model
{
    public function educationPatient() {
    	return $this->belongsTo('App\Models\Patient','patient_id');
    }
}
