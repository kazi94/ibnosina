<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\act_medicale;

class ActPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the patient.
     *
     * @param  \App\User  $user
     * @param  \App\Patient  $patient
     * @return mixed
     */

    public function view(User $user)
    {
            return  self::getPermission($user , 'lister_act');
    }

    public function module(User $user)
    {
            return  self::getPermission($user , 'lister_details_act');
    }    

    /**
     * Determine whether the user can create patients.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
          return  self::getPermission($user , 'ajouter_act');
    }

    /**
     * Determine whether the user can update the patient.
     *
     * @param  \App\User  $user
     * @param  \App\Patient  $patient
     * @return mixed
     */
    public function update(User $user)
    {
        return  self::getPermission($user , 'modifier_act');
    }

    /**
     * Determine whether the user can delete the patient.
     *
     * @param  \App\User  $user
     * @param  \App\Patient  $patient
     * @return mixed
     */
    public function delete(User $user)
    {
        return  self::getPermission($user , 'supprimer_act');
    }

    public function export(User $user)
    {
        return  self::getPermission($user , 'exporter_act');
    }
    public function print(User $user)
    {
        return  self::getPermission($user , 'imprimer_act');
    }

    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
