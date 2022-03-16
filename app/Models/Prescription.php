<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'consultation_id',
        'created_by',
        'last_presc_id',
        'etats',
        'date_prescription'
    ];

    protected $appends = ['lastDate'];

    public function lignes()
    {
        return $this->hasMany('App\Models\Ligneprescription');
    }
    public function bilans()
    {
        return $this->hasMany('App\Models\Bilan');
    }
    public function prescripteur()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
    public function intervention()
    {
        return $this->hasOne('App\Models\Intervention');
    }
    public function number_of_lines()
    {
        return $this->hasMany('App\Models\Ligneprescription')->select('id')->get();
    }

    public function jMax()
    {
        return $this->hasOne('App\Models\Ligneprescription')
            ->latest('nbr_jours');
    }

    public function getLastDateAttribute()
    {
        $jours = isset($this->jMax['nbr_jours']) ? $this->jMax['nbr_jours'] : 0;
        return
            date('Y-m-d', strtotime("+" . $jours . " day", strtotime($this->date_prescription)));
    }
}
