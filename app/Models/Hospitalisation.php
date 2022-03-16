<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitalisation extends Model
{
    protected $fillable = [
        'hopital',
        'service',
        'num_biais',
        'chambre',
        'lit',
        'motifs',
        'date_admission',
        'date_sortie',
        'motif_sortie',
        'service_transfert',
    ];
}
