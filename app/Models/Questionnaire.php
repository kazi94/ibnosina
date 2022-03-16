<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
	public $timestamps = false;
    public function questions () {
    	return $this->hasMany('App\Models\Question');
    }

    public function user () {
    	return $this->belongsTo('App\User');
    }
}
