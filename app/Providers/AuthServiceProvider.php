<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Models\Patient::class => App\PatientPolicy::class,
        Models\Hospitalisation::class => App\HospitalisationPolicy::class,
        ModelsChimio\Prescription::class => App\PrescriptionChimioPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('chimio.view', 'App\Policies\PrescriptionChimioPolicy@view');
        Gate::define('dashboard.view', 'App\Policies\DashboardPolicy@view');
        Gate::define('dashboard.create', 'App\Policies\DashboardPolicy@create');
        Gate::define('dashboard.edit', 'App\Policies\DashboardPolicy@edit');
        Gate::define('dashboard.delete', 'App\Policies\DashboardPolicy@delete');

        Gate::define('compte_patient.view', 'App\Policies\ComptePolicy@view');
        Gate::define('compte_patient.create', 'App\Policies\ComptePolicy@create');
        Gate::define('compte_patient.update', 'App\Policies\ComptePolicy@update');
        Gate::define('compte_patient.delete', 'App\Policies\ComptePolicy@delete');

        Gate::define('compte_externe.view', 'App\Policies\UserExPolicy@view');
        Gate::define('compte_externe.create', 'App\Policies\UserExPolicy@create');
        Gate::define('compte_externe.update', 'App\Policies\UserExPolicy@update');
        Gate::define('compte_externe.delete', 'App\Policies\UserExPolicy@delete');

        Gate::resource('patients', 'App\Policies\PatientPolicy');
        Gate::define('patients.export', 'App\Policies\PatientPolicy@export');
        Gate::define('patients.valide', 'App\Policies\PatientPolicy@traite');
        Gate::define('patients.module', 'App\Policies\PatientPolicy@module');

        Gate::resource('consultations', 'App\Policies\ConsultationPolicy');
        Gate::define('consultations.module', 'App\Policies\ConsultationPolicy@module');
        Gate::define('consultations.export', 'App\Policies\ConsultationPolicy@export');
        Gate::define('consultations.print', 'App\Policies\ConsultationPolicy@print');

        Gate::resource('prescriptions', 'App\Policies\PrescriptionPolicy');
        Gate::define('prescriptions.module', 'App\Policies\PrescriptionPolicy@module');
        Gate::define('prescriptions.export', 'App\Policies\PrescriptionPolicy@export');
        Gate::define('prescriptions.print', 'App\Policies\PrescriptionPolicy@print');
        Gate::define('prescriptions.clone', 'App\Policies\PrescriptionPolicy@clone');
        Gate::define('prescriptions.inject', 'App\Policies\PrescriptionPolicy@inject');

        Gate::resource('analyses_biologique', 'App\Policies\AnalyseBiologiquePolicy');
        Gate::define('analyses_biologique.module', 'App\Policies\AnalyseBiologiquePolicy@module');
        Gate::define('analyses_biologique.export', 'App\Policies\AnalyseBiologiquePolicy@export');
        Gate::define('analyses_biologique.dessin', 'App\Policies\AnalyseBiologiquePolicy@dessiner');
        Gate::define('analyses_biologique.executeRequest', 'App\Policies\AnalyseBiologiquePolicy@executeRequest');

        Gate::resource('automedications', 'App\Policies\AutomedicationPolicy');
        Gate::define('automedications.module', 'App\Policies\AutomedicationPolicy@module');
        Gate::define('automedications.export', 'App\Policies\AutomedicationPolicy@export');

        Gate::resource('traitements_chronique', 'App\Policies\TraitementChroniquePolicy');
        Gate::define('traitements_chronique.module', 'App\Policies\TraitementChroniquePolicy@module');
        Gate::define('traitements_chronique.export', 'App\Policies\TraitementChroniquePolicy@export');

        Gate::resource('phytotherapies', 'App\Policies\PhytotherapiePolicy');
        Gate::define('phytotherapies.module', 'App\Policies\PhytotherapiePolicy@module');
        Gate::define('phytotherapies.export', 'App\Policies\PhytotherapiePolicy@export');

        Gate::resource('questionaires', 'App\Policies\ObservancePolicy');
        Gate::define('questionaires.module', 'App\Policies\ObservancePolicy@module');
        Gate::define('questionaires.export', 'App\Policies\ObservancePolicy@export');

        Gate::resource('hospitalisations', 'App\Policies\HospitalisationPolicy');
        Gate::define('hospitalisations.module', 'App\Policies\HospitalisationPolicy@module');
        Gate::define('hospitalisations.export', 'App\Policies\HospitalisationPolicy@export');
        Gate::define('hospitalisations.print', 'App\Policies\HospitalisationPolicy@print');

        Gate::resource('dashboard', 'App\Policies\DashboardPolicy');

        Gate::resource('act_medicales', 'App\Policies\ActPolicy');
        Gate::define('act_medicales.export', 'App\Policies\ActPolicy@export');
        Gate::define('act_medicales.print', 'App\Policies\ActPolicy@print');
        Gate::define('act_medicales.module', 'App\Policies\ActPolicy@module');


        Gate::resource('educations_therapeutique', 'App\Policies\EducationTherapeutiquePolicy');
        Gate::define('educations_therapeutique.export', 'App\Policies\EducationTherapeutiquePolicy@export');
        Gate::define('educations_therapeutique.module', 'App\Policies\EducationTherapeutiquePolicy@module');

        Gate::define('peut-analyser', function ($user) {
            if ($user->role_id == '1' || $user->role->analyse_ph == "on")
                return true;
            else  false;
        });

        Gate::define('analyse_therap', function ($user) {
            if ($user->role_id == '1' || $user->role->analyse_th == "on")
                return true;
            else  false;
        });

        Gate::define('analyse_suiv', function ($user) {
            if ($user->role_id == '1' || $user->role->analyse_sv == "on")
                return true;
            else  false;
        });

        Gate::define('editeur_regle', function ($user) {
            if ($user->role_id == '1' || $user->role->editeur_regle == "on")
                return true;
            else  false;
        });

        Gate::define('is-admin', function ($user) {
            // if ($user->role_id == 1) return true;
            if ($user->is_admin == 'on' || $user->role_id == 1) return true;
            else return false;
        });


        Gate::resource('prescriptionChimio', 'App\Policies\PrescriptionChimioPolicy');
        Gate::define('prescriptionChimio.lister', 'App\Policies\PrescriptionChimioPolicy@lister');


        Gate::define('ChimioPolicy.okChimio', 'App\Policies\ChimioPolicy@okChimio');
        Gate::define('ChimioPolicy.verif_medic', 'App\Policies\ChimioPolicy@verif_medic');
    }
}
