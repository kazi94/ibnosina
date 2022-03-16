<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Injection extends Model
{
    public $timestamps = false;

    protected $fillable = ['injected', 'prise', 'injected_at', 'injected_by', 'day_j'];

    protected $appends = ['posologie', 'custom_injected_at'];


    public function administrator()
    {
        return $this->belongsTo('App\User', 'injected_by');
    }

    public function line()
    {
        return $this->belongsTo('App\Models\LignePrescription', 'line_id');
    }

    public function getCustomInjectedAtAttribute()
    {
        return date('m-d-Y', strtotime($this->injected_at));
    }

    public function getPosologieAttribute()
    {
        switch ($this->prise) {
            case 'matin':
                $color = "green";
                break;
            case 'midi':
                $color = "blue";
                break;
            case 'soir':
                $color = "orange";
                break;
            case 'coucher':
                $color = "red";
                break;

            default:
                $color = "black";
                break;
        }

        $this->prise = $this->prise == "coucher" ? "Avant-Coucher" : ucfirst($this->prise);

        return "<b style='color : $color'>$this->prise</b>";
    }
}
