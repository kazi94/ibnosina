<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class StadeChimio extends Model
{
    protected $table = 'stade_chimios';
    public $timestamps = false;
    public $incrementing = false;

    public function pathologies(){
        return $this->belongsToMany('App\ModelsChimio\Pathologies','pathologies_stade','stade_chimios_id', 'pathologies_id');
    }
}
