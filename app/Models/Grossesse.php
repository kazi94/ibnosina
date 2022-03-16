<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grossesse extends Model
{
    public $timestamps = false;
    public $incrementing = false; // say that primary key is not ai
    public $keyType = 'string'; //say that type of primary key is not integer

}
