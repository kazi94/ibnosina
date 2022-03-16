<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Protocole extends Model
{
    protected $table = 'protocole';

    public function sequencetype()
    {
        return $this->hasMany('App\ModelsChimio\sequencetype');
    }

    public function pathologies()
    {
        return $this->belongsToMany('App\ModelsChimio\Pathologies','pathologies_protocole','protocole_id', 'pathologies_id');
    }

     public function traitements()
    {
        return $this->hasMany('App\ModelsChimio\Traitement');
    }

    public function sequences()
    {
        return $this->hasMany('App\ModelsChimio\Sequence');
    }

}
