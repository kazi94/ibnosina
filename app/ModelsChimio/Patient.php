<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    protected $table = 'patients';
  

    public function traitements(){
        return $this->hasMany('App\ModelsChimio\Traitement');
    }

    public function age($date){
	  return '( '.(int)((time()-strtotime($date)) / 31557600).' ans '.(((time()-strtotime($date)) / 2629800)%12).' mois )';
	}
   
}
