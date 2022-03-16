<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AutomedicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the patient.
     *
     * @param  \App\User  $user
     * @param  \App\Patient  $patient
     * @return mixed
     */
    public function module(User $user)
    {
            return  self::getPermission($user , 'lister_details_auto');
    }
    public function view(User $user)
    {
            return  self::getPermission($user , 'lister_auto');
    }

    /**
     * Determine whether the user can create patients.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
          return  self::getPermission($user , 'ajouter_auto');
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
        return  self::getPermission($user , 'modifier_auto');
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
        return  self::getPermission($user , 'supprimer_auto');
    }
    public function export(User $user)
    {
        return  self::getPermission($user , 'exporter_auto');
    }
    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
