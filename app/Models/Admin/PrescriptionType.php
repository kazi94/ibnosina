<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrescriptionType extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'type', 'service', 'elements'];

    /**
     * Get all prescriptions type service
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection
     */
    public function servicesType()
    {
        return $this->hasMany('App\Models\Admin\PrescriptionService');
    }
    /**
     * Get all prescriptions type examen
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection
     */
    public function examensType()
    {
        return $this->hasMany('App\Models\Admin\PrescriptionExamen');
    }
    /**
     * Get all prescriptions type service by auth user's service
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection
     */
    public function services()
    {
        return $this->servicesType()->whereType('service')->whereService(Authh::user()->service);
    }

    /**
     * Get All prescriptions type exams by auth user's service
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection
     */
    public function examens()
    {
        return $this->examensType()->whereType('examen')->whereService(Authh::user()->service);
    }
}
