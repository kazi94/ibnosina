<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	public $timestamps = false;
	public function user() {
		return $this->belongsTo('App\User','user');
	}

	// public function getTimeAttribute($val) {
	// 	return date('H:i' , $val);
	// }
}
