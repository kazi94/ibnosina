<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Cure extends Model
{
    protected $table = 'cure';

    public function traitements(){
        return $this->belongsTo('App\ModelsChimio\Traitement');
    }

    public function sequences(){
        return $this->hasMany('App\ModelsChimio\Sequence');
    }
}
