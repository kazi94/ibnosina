<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
	protected $fillable = [
		'motif',
		'debut_symptome',
		'examen',
		'compte_rendu',
		'orientation',
		'certificat',
		'date_consultation'
	];

	public function patient()
	{
		return $this->belongsTo("App\Models\Patient");
	}
	public function signes()
	{
		return $this->belongsToMany("App\Models\Signe");
	}
	public function userCreate()
	{
		return $this->belongsTo('App\User', 'created_by');
	}
	public function userUpdate()
	{
		return $this->belongsTo('App\User', 'updated_by');
	}
}
