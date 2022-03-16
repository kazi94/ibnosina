<?php

namespace App\Repositories\User;

use Illuminate\Contracts\Cache\Factory;
use App\Models\Patient;
use App\Services\PhotoService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\Interfaces\PatientRepositoryInterface;


class Patients implements PatientRepositoryInterface
{
    private $patient;
    private $photoService;
    /**
     * Undocumented function
     *
     * @param Patient $patient
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     */

    public function __construct(Patient $patient, PhotoService $photoService)
    {
        $this->patient = $patient;
        $this->photoService = $photoService;
    }
    /**
     * get all the patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patients
     */
    public function getAll()
    {
        return $this->patient::all();
    }

    /**
     * get all the current patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patients
     */
    public function getAvalaibles()
    {
        // return
        //     $this->patient::with('hospi', 'villes')
        //     ->whereNull('archived')
        //     ->orderBy('created_at', 'desc')
        //     ->select('id', 'created_at', 'num_dossier', 'nom', 'photo', 'prenom', 'date_naissance', 'poids', 'taille', 'travaille', 'travaille1', 'num_tel_1', 'sexe')
        //     ->get();

        return \DB::table('patients')
            ->leftJoin('hospitalisations', 'patients.id', 'hospitalisations.patient_id')
            ->leftJoin('wilayas', 'patients.ville', 'wilayas.id')
            ->whereIn('date_admission', function ($query) {
                $query->selectRaw('max(date_admission)')
                    ->from('hospitalisations')
                    ->groupBy('patient_id');
            })
            ->whereNull('archived')
            ->orderBy('patients.created_at', 'desc')
            ->select(
                'patients.id',
                'patients.created_at',
                'num_dossier',
                'nom',
                'photo',
                'prenom',
                'date_naissance',
                'poids',
                'taille',
                'travaille',
                'travaille1',
                'num_tel_1',
                'sexe',
                'hospitalisations.chambre',
                'hospitalisations.service',
                'hospitalisations.lit',
                'hospitalisations.motif_sortie',
                'hospitalisations.date_sortie',
                'hospitalisations.date_admission',
                'hospitalisations.service_transfert',
                'wilayas.name'
            )
            ->get();
    }

    /**
     * get archived patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patients
     */
    public function getArchived()
    {
        return  $this->patient::with('hospi')
            ->whereNotNull('archived')
            ->get();
    }

    /**
     * Find patient by ID
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findById($id)
    {
        return Patient::findOrFail($id);
    }
    /**
     * Retrieve Patient Folder by ID
     *
     * @param  $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findByIdWithFolder($id)
    {
        return Patient::with(
            'interventions',
            'villes',
            'communes',
            'interventionsValide',
            'pathologies',
            'allergies',
            'hospi',
            'bilans',
            'bilansRadiologique',
            'consultations.signes',
            'questionnaires',
            'traitements.lignes',
            'autos.lignes',
            'tmp_traitements',
            'tmp_autos',
            'phytos',
            'educations',
            'prescriptions.prescripteur',
            'prescriptions.lignes',
            'prescriptionsDesc.lignes',
            // 'prescriptionsToInject.lignes',
            'prescriptionsRetroInvalide',
            'operations',
            'requestExams'
        )->find($id);
    }

    /**
     * store patient to database
     *
     * @param Object $attributes
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function create($attributes)
    {
        $filename = "user.jpg";

        if ($attributes->photo)
            $filename = $this->photoService->storePhoto($attributes->file('photo'));

        $patient = $this->patient->create($attributes->toArray());
        $patient->created_by = Auth::user()->id;
        $patient->photo = $filename;
        $patient->save();

        //associate patient with pathologies
        isset($attributes->pathologies) ?
            $this->syncPathologies($patient, $attributes->pathologies) : '';

        //associate patient with antecedents
        isset($attributes->famille_antecedants) ?
            $this->syncAntecedents($patient, $attributes->famille_antecedants) : '';

        //associate patient with allergie
        $patient->allergies()->sync($attributes->allergies);

        $patient->operations()->sync($attributes->operations);

        return $patient;
    }
    /**
     * Get all hospitalized patients
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function getHospitalisedPatients()
    {
        return Patient::with('hospi', 'villes')->get();
    }
    /**
     * Sync Patient with antecedent in patient_pathologie table
     *
     * @param Patient $patient
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function syncAntecedents($patient, $antecedents)
    {
        foreach ($antecedents as $ant) {
            //collect all inserted record IDs
            $ant_id_array[$ant] = ['type' => 'ant'];
            // sync with pathologies
        }
        $patient->antecedentsFamilliaux()->sync($ant_id_array, false);
    }

    /**
     * Sync Pathologies with Patient 
     *
     * @param Patient $patient
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    protected function syncPathologies($patient, $pathologies)
    {
        foreach ($pathologies as $path) {
            //collect all inserted record IDs
            $path_id_array[$path] = ['type' => 'path'];
        }
        $patient->pathologies()->sync($path_id_array);
    }

    /**
     * get patients by searched name
     *
     * @param [type] $name
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Collection
     */
    public function searchByName($name)
    {
        return Patient::where('nom', 'like', '%' . $name . '%')->get();
    }
    /**
     * Get patient profil
     *
     * @param [type] $id
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Patient
     */
    public function findProfilById($id)
    {
        return Patient::with('pathologies', 'allergies', 'antecedentsFamilliaux')->find($id);
    }
}
