<?php

namespace Tests\Feature;

use App\Models\Automedication;
use App\Models\Bilan;
use App\Models\Consultation;
use App\Models\Hospitalisation;
use App\Models\LignePrescription;
use App\Models\Patient;
use Tests\TestCase;
use App\Models\Prescription;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class PatientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDatabase()
    {
        $patients = factory(Patient::class, 500)
            ->create()
            ->each(function ($patient) {
                $patient->consultations()->createMany(
                    factory(Consultation::class, 20)->make()->toArray()
                );
                $patient->hospitalisation()->createMany(
                    factory(Hospitalisation::class, 3)->make()->toArray()
                );
                $patient->prescriptions()->createMany(
                    factory(Prescription::class, 30)
                        ->make()
                        ->each(function ($prescription) {
                            $prescription->lignes()->createMany(
                                factory(LignePrescription::class, 10)->make()->toArray()
                            );
                        })
                        ->toArray()
                );
            });
        //$patients = factory(App\User::class, 3)
        //  ->has(Consultation::factory()->count(3), 'consultations')
        // ->has(Hospitalisation::factory()->count(3), 'hospitalisation')
        // ->has(
        //     Prescription::factory()
        //         ->has(Ligneprescription::factory()->count(3), 'lignes')
        //         ->count(3),
        //     'prescriptions'
        // )
        // ->has(Bilan::factory()->count(3), 'bilans')
        // ->has(Automedication::factory()->count(3), 'automedications')
        // ->create();
    }
}
