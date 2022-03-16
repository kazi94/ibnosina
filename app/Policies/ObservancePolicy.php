<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObservancePolicy
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
        return  $this->getPermission($user, 'lister_question');
    }

    /**
     * Determine whether the user can create patients.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  $this->getPermission($user, 'ajouter_question');
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
        return  $this->getPermission($user, 'modifier_question');
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
        return  $this->getPermission($user, 'supprimer_question');
    }
    public function module(User $user)
    {
        return  $this->getPermission($user, 'lister_details_question');
    }
    public function export(User $user)
    {
        return  $this->getPermission($user, 'exporter_question');
    }
    protected function getPermission($user, $r_name)
    {
        if ($user->role_id == 1 || $user->role->$r_name == 'on') {
            return true;
        }
        return false;
    }
}
