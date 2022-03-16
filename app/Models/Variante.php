<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    public $timestamps = false;

    protected $fillable = ['min' , 'max' ,'unite' ,'sexe' , 'element_id'];

    public function element(){
        return $this->belongsTo('App\Models\Element');
    }
}
