<?php

namespace App\Repositories\Admin;

use App\Models\Admin\PrescriptionService;

class PrescriptionServices
{
    protected $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function findById($id)
    {
        return $this->consultation::findOrFail($id);
    }

    public function updateRapport($data, $id)
    {
        $consultation = $this->findById($id);
        $consultation->compte_rendu      = $data->compte_rendu;
        $consultation->orientation       = $data->orientation;
        $consultation->certificat        = $data->certificat;
        $consultation->updated_at        = date('Y-m-d H:i:s');
        $consultation->updated_by        = $data->user()->id;
        $consultation->save();

        return $consultation;
    }
}
