<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Appointement extends Model
{
    public function patient (){
    	return $this->belongsTo('App\Models\Patient');
    }

    public function appointedBy(){
    	return $this->belongsTo('App\User','created_by')->where('service' ,Auth::user()->service);
    }
}
