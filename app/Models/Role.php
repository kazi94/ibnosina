<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
        /**
     * The roles that belong to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
}
