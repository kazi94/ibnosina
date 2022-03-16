<?php

namespace App\Models;

// use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Model;

class Pathologie extends Model
{
	// use QueryCacheable;

	// public $cacheFor = 3600000; // cache time, in seconds

	public $timestamps = false;
	public $incrementing = false; // say that primary key is not ai
	public $keyType = 'string'; //say that type of primary key is not integer

	// public function getPathologieAttribute($val)
	// {
	// 	return ucfirst(strtolower($val));
	// }
}
