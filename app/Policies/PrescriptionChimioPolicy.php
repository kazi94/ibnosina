<?php

namespace App\Policies;

use App\User;
use App\ModelsChimio\Prescription;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionChimioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the prescription.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsChimio\Prescription  $prescription
     * @return mixed
     */
    public function lister(User $user)
    {
        return  self::getPermission($user ,'lister_Prescription_chimio');
    }

    public function view(User $user)
    {
            return  self::getPermission($user , 'lister_Prescription_chimio');
    }

    public function show(User $user)
    {
            return  self::getPermission($user , 'lister_details_Prescription_chimio');
    }    

    /**
     * Determine whether the user can create prescriptions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  self::getPermission($user , 'ajouter_Prescription_chimio');
    }

    /**
     * Determine whether the user can update the prescription.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsChimio\Prescription  $prescription
     * @return mixed
     */
    public function update(User $user)
    {
        return  self::getPermission($user , 'modifier_Prescription_chimio');
    }

    /**
     * Determine whether the user can delete the prescription.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsChimio\Prescription  $prescription
     * @return mixed
     */
    public function delete(User $user)
    {
        return  self::getPermission($user , 'supprimer_Prescription_chimio');
    }

    protected function getPermission($user , $r_name)
    {
        if ($user->role_id == '1' || $user->role->$r_name == 'on') {
             return true;
            }
        return false;
    }
}
