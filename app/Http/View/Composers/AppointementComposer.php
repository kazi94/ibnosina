<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Repositories\AppointementRepository;
use Auth;
class AppointementComposer
{
    /**
     * The user repository implementation.
     *
     * @var AppointementRepository
     */
    protected $appointement;

    /**
     * Create a new profile composer.
     *
     * @param  AppointementRepository  $appointement
     * @return void
     */
    public function __construct(AppointementRepository $appointement)
    {
        // Dependencies automatically resolved by service container...
        $this->appointement = $appointement;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
       //if (Auth::check())  $view->with('appointements', $this->appointement->getDailyAppointements());
    }
}