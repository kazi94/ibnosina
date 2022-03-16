<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Repositories\UtilityRepository;
use App\Repositories\User\Interfaces\PatientRepositoryInterface;



class PatientController extends Controller
{
    private $patientRepo;
    private $utilityRepository;

    public function __construct(PatientRepositoryInterface $patientRepo, UtilityRepository $utilityRepository)
    {
        $this->patientRepo = $patientRepo;
        $this->utilityRepository = $utilityRepository;
    }

    public function fetch($id)
    {
        return response()->json($this->patientRepo->findById($id), 200);
    }

    public function getDairasByVille($id)
    {
        $util = new UtilityRepository();
        return response()->json($util->getDairas($id), 200);
    }

    /**
     * Search name of exisiting patient
     *
     * @param [type] $phrase
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function search(Request $req)
    {
        return response()->json($this->patientRepo->searchByName($req->nom), 200);
    }
    /**
     * return profile patient en format json à la requete ajax
     *
     * @return Patient
     * @author WhiteSalafiDev
     **/
    public function fetchProfile($id)
    {
        $patient = $this->patientRepo->findProfilById($id);
        $pathologies = $this->utilityRepository->getPathologies();
        $allergies   = $this->utilityRepository->getAllergies();
        return response()->json([
            'patient'     => $patient,
            'pathologies' => $pathologies,
            'pathologies_v1' => $pathologies,
            'allergies'   => $allergies,
        ]);
    }
}
