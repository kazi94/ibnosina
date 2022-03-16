<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bilan extends Model
{


    public function element(){
    	return $this->belongsTo('App\Models\Element'); // link this->element_id to elements.id
    }
    public function elements(){
    	return $this->belongsToMany('App\Models\Element'); // link this->element_id to elements.id
    }
}
