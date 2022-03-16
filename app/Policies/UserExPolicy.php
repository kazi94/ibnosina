<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Dashboard;

class UserExPolicy
{
    use HandlesAuthorization;
    

    public function view(User $user)
    {
            return  self::getPermission($user , 'lister_cpt_ext');
    }

    public function show(User $user)
    {
            return  self::getPermission($user , 'lister_details_cpt_ext');
    }    

    public function create(User $user)
    {
          return  self::getPermission($user , 'ajouter_cpt_ext');
    }

    public function update(User $user)
    {
        return  self::getPermission($user , 'modifier_cpt_ext');
    }

    public function delete(User $user)
    {
        return  self::getPermission($user , 'supprimer_cpt_ext');
    }

    public function export(User $user)
    {
        return  self::getPermission($user , 'exporter_cpt_ext');
    }
    public function print(User $user)
    {
        return  self::getPermission($user , 'imprimer_cpt_ext');
    }

    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
