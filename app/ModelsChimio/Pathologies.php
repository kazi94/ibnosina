<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Pathologies extends Model
{
	protected $table = 'pathologies';
	public $timestamps =false;
    public $incrementing = false;

    public function protocoles()
    {
        return $this->belongsToMany('App\ModelsChimio\Protocole','pathologies_protocole','pathologies_id', 'protocole_id');
    }

    public function stades()
    {
        return $this->belongsToMany('App\ModelsChimio\StadeChimio','pathologies_stade','pathologies_id', 'stade_chimios_id');
    }

    public function traitements()
    {
        return $this->hasMany('App\ModelsChimio\Traitement');
    }
}
