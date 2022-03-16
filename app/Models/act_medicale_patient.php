<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class act_medicale_patient extends Model
{
    public function acts(){
		return $this->hasMany('App\Models\act_medicale'); // the second argument is used to determine the foreign key of user in patients tables
	}
}
