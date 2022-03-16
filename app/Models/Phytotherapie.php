<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Phytotherapie extends Model
{
    public function produit()
    {
        return $this->belongsTo('App\Models\Produitalimentaire', 'produitalimentaire_id'); //about calling in blade : $phyto->['colNameProduitalimentaireTable']
    }

    public function utilisation()
    {
        return $this->belongsTo('App\Models\Pathologie', 'used_on', 'id');
    }
}
