<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescriptions_chimio';
    public $timestamps = false;

    public function users(){
        return $this->belongsTo('App\ModelsChimio\users');
    }

    public function sequences(){
        return $this->belongsTo('App\ModelsChimio\Sequence');
    }

}
