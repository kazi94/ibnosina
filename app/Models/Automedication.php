<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Automedication extends Model
{
    public function lignes () {
    	return $this->hasMany('App\Models\Ligneprescription');
    }
}
