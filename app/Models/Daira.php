<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daira extends Model
{
    public $timestamps = false;
}
// hasone :
// SQL: select * from `users` where `users`.`prescription_id` = 2 and `users`.`prescription_id` is not null limit 1
// has many , the foreign key of the self model is in the parient model , only difference retun many instance than 1 , besides of hasone