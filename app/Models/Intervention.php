<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Intervention extends Model
{
    public $timestamps = false;
    public function lignesIP()
    {
        return $this->hasMany('App\Models\LigneIntervention');
    }

    public function countIp()
    {
        return $this->hasMany('App\Models\LigneIntervention')
            // To get Specific Column(s) you must include in your select methode
            //the Id of Table , and the foreign key
            ->select('id', 'intervention_id', DB::raw("count(ip) as compt"), 'ip')
            ->groupBy('ip');
    }

    public function countProblems()
    {
        return $this->hasMany('App\Models\LigneIntervention')
            ->select('id', 'intervention_id', DB::raw("count(problemes) as compt"), 'problemes')
            ->groupBy('problemes');
    }

    public function analyseur()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function executeur()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
