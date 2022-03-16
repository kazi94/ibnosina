<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        // 1st argument take the view
        View::composer(
            '*', 'App\Http\View\Composers\AppointementComposer'
        );
        View::composer(
            '*', 'App\Http\View\Composers\MessageComposer'
        );        

        // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            //
        });
    }
}