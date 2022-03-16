<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\Interfaces\PrescriptionRepositoryInterface;
use App\Repositories\User\Interfaces\PatientRepositoryInterface;
use App\Repositories\User\Patients;
use App\Repositories\User\Prescriptions;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PrescriptionRepositoryInterface::class, Prescriptions::class);
        $this->app->bind(PatientRepositoryInterface::class, Patients::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
