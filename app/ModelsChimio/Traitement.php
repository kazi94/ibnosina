<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    protected $table = 'traitements';

    public function protocoles(){
        return $this->belongsTo('App\ModelsChimio\Protocole');
    }

    public function patients(){
        return $this->belongsTo('App\ModelsChimio\Patient');
    }

    public function medecins(){
        return $this->belongsTo('App\ModelsChimio\users');
    }

    public function pathologies(){
        return $this->belongsTo('App\ModelsChimio\Pathologies');
    }

    public function cures(){
        return $this->hasMany('App\ModelsChimio\Cure');
    }
    
}
