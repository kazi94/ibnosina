<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Traitementchronique extends Model 
{
    public function lignes () {
    	return $this->hasMany('App\Models\Ligneprescription');
    }
    public function user () {
    	return $this->belongsTo('App\User' , 'created_by');
    }

        public function user_update () {
    	return $this->belongsTo('App\User' , 'updated_by');
    }
}
