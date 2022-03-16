<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public function element(){
    	return $this->belongsTo('App\Models\Element'); // link this->element_id to elements.id
    }
}
