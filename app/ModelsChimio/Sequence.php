<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    protected $table = 'sequences';
    public $timestamps = false;
    
    public function protocoles(){
        return $this->belongsTo('App\ModelsChimio\Protocole');
    }

    public function cures(){
        return $this->belongsTo('App\ModelsChimio\Cure');
    }

    public function prescriptiosChimio(){
        return $this->hasMany('App\ModelsChimio\Prescription');
    }

    public function medicaments(){
        return $this->belongsToMany('App\ModelsChimio\Medicament','medicament_sequence','sequence_id', 'medicament_id')->withPivot('date_debut', 'heure', 'remarque', 'posologie', 'voie', 'type', 'dose_calcule','etat','reduction','solvant');
    }
}
