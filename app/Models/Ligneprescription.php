<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Ligneprescription extends Model
{
    protected $fillable = [
        'nbr_jours',
        'comment',
        'medecin_externe',
        'etats',  'date_etats',  'status_hopital',
        'dose',  'type_j',  'dose_matin', 'dose_mat', 'repas_matin',
        'dose_midi', 'repas_midi', 'dose_mid',
        'dose_soir', 'repas_soir', 'dose_soi',
        'dose_avant_coucher', 'dose_ac',
        'unite', 'voie',
        'med_sp_id', 'prescription_id',
        'traitementchronique_id', 'automedication_id',
        'updated_at', 'created_at', 'tmp',
        'stopped', 'stopped_at'
    ];

    public function medicaments()
    {
        return $this->belongsToMany('App\Models\Sac_subactive', 'ligneprescription_sac_subactive', 'ligneprescription_id', 'sac_subactive_id'); // default table : ligneprescription_sac_subactive
    }

    public function medicament()
    {
        return $this->belongsTo('App\Models\Sp_specialite', 'med_sp_id');
    }
    public function prescription()
    {
        return $this->belongsTo('App\Models\Prescription');
    }
    public function injections()
    {
        return $this->hasMany('App\Models\Injection', 'line_id');
    }

    public function todayInjections()
    {
        return $this->hasMany('App\Models\Injection', 'line_id')
            ->whereDate('injected_at', date('Y-m-d'));
    }

    public function getJoursRestantAttribute()
    {
        $today = new DateTime(date('Y-m-d'));

        $created_at = new DateTime($this->created_at->format('Y-m-d'));

        $difference = $today->diff($created_at);

        return $difference->d;
    }
}
