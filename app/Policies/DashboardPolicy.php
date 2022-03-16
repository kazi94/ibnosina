<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Dashboard;

class DashboardPolicy
{
    use HandlesAuthorization;


    public function view(User $user)
    {
            return  self::getPermission($user , 'lister_dashboard');
    }

    public function create(User $user)
    {
          return  self::getPermission($user , 'ajouter_dashboard');
    }

    public function edit(User $user)
    {
        return  self::getPermission($user , 'modifier_dashboard');
    }

    public function delete(User $user)
    {
        return  self::getPermission($user , 'supprimer_dashboard');
    }


    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
