<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChimioPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    


    public function okChimio(User $user)
    {
        return  self::getPermission($user ,'ok_chimio');
    }

    public function verif_medic(User $user)
    {
        return  self::getPermission($user ,'verif_medic');
    }

    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == '1' || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
