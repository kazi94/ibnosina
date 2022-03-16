<?php

namespace App\Repositories\User;

use App\Models\Prescription;
use App\Repositories\User\Interfaces\PrescriptionRepositoryInterface;

class Prescriptions implements PrescriptionRepositoryInterface
{
    public function create($data)
    {
        $prescription = Prescription::create([
            'patient_id'        => $data->patient_id,
            'consultation_id'   => $data->cons_id,
            'created_by'        => $data->user()->id,
            'last_presc_id'     => $data->last_presc_id,
            'etats'             => 'prescription',
            'date_prescription' => $data->date_prescription
        ]);


        $prescription->lignes()->createMany($data->lines);

        return $prescription;
    }

    /**
     * get lines of prescription
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Prescription
     */
    public static function getLinesById($id)
    {
        return Prescription::with('lignes')->findOrFail($id);
    }
}
