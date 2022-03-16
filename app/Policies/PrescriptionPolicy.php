<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
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
        return  self::getPermission($user, 'lister_details_prescription');
    }
    public function view(User $user)
    {
        return  self::getPermission($user, 'lister_prescription');
    }

    /**
     * Determine whether the user can create patients.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  self::getPermission($user, 'ajouter_prescription');
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
        return  self::getPermission($user, 'modifier_prescription');
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
        return  self::getPermission($user, 'supprimer_prescription');
    }
    public function export(User $user)
    {
        return  self::getPermission($user, 'exporter_prescription');
    }
    public function clone(User $user)
    {
        return  self::getPermission($user, 'cloner_prescription');
    }
    public function print(User $user)
    {
        return  self::getPermission($user, 'imprimer_prescription');
    }
    public function inject(User $user)
    {
        return  self::getPermission($user, 'administrer');
    }
    protected function getPermission($user, $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
            return true;
        }
        return false;
    }
}
