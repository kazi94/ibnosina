<?php

namespace App\Repositories\User\Interfaces;

use Illuminate\Support\Collection;

interface PatientRepositoryInterface
{
    /**
     * get all patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection List of Patients
     */
    public function getAll();
    /**
     * get all the current patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patients
     */
    public function getAvalaibles();
    /**
     * get archived patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patients
     */
    public function getArchived();
    /**
     * Find patient by ID
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findById($id);
    /**
     * find Patient
     *
     * @param  $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findByIdWithFolder($id);
    /**
     * store patient to database
     *
     * @param Object $attributes
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function create($data);

    /**
     * get patients by searched name
     *
     * @param [type] $name
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection Collection of Patient Model(s)
     */
    public function searchByName($name);
    /**
     * Get all hospitalized patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getHospitalisedPatients();

    /**
     * Get patient profil
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findProfilById($id);
}
