<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $primaryKey = 'SP_CODE_SQ_PK';
    protected $table = 'sp_specialite';

    public function sequences(){
        return $this->belongsToMany('App\ModelsChimio\Sequence','medicament_sequence','medicament_id', 'sequence_id')->withPivot('date_debut', 'heure', 'remarque', 'posologie', 'voie', 'type', 'dose_calcule','etat','reduction','solvant','u1','u2','u3');
    }
}
