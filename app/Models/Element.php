<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public $timestamps = false;

    protected $fillable = ['bilan' , 'element'];

    public function variantes(){
        return $this->hasMany('App\Models\Variante');
    }


    public function variante(){
        return $this->hasOne('App\Models\Variante')->first();
    }
}
