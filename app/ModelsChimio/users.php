<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = 'users';

    public function traitements()
    {
        return $this->hasMany('App\ModelsChimio\Traitement');
    }

    public function prescriptiosChimio()
    {
        return $this->hasMany('App\ModelsChimio\Prescription');
    }


}
