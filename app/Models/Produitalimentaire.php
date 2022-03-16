<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Produitalimentaire extends Model
{
    public function interactions(){

    	return $this->hasMany('App\Models\Interaction');
    }
}
