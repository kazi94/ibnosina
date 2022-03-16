<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrescriptionExamen extends Model
{
    protected $fillable = ['element_id', 'prescription_type_id'];

    public $timestamps = false;

    public function element()
    {
        return $this->belongsTo('App\Models\Element'); // link this->element_id to elements.id
    }
}
