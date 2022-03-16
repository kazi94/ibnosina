<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrescriptionService extends Model
{
    protected $fillable = ['nbr_jours', 'dose',  'type_j',  'dose_matin', 'dose_mat', 'repas_matin', 'dose_midi', 'repas_midi', 'dose_mid', 'dose_soir', 'repas_soir', 'dose_soi', 'dose_avant_coucher', 'dose_ac', 'unite', 'voie', 'med_sp_id', 'prescription_type_id'];

    public $timestamps = false;
    public function medicament()
    {
        return $this->belongsTo('App\Models\Sp_specialite', 'med_sp_id');
    }
}
