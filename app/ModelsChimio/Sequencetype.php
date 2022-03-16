<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Sequencetype extends Model
{
    protected $table = 'sequencetype';
    public $timestamps = false;

    public function protocole()
    {
        return $this->belongsTo('App\ModelsChimio\Protocole');
    }

    public function medicament()
    {
        return $this->hasMany('App\ModelsChimio\Medicament_sequencetype');
    }

}
