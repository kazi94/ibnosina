<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artisan;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function optimize()
    {
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
    }
    public function getApp()
    {
        if (Auth::user()) return redirect('patient');
        else return view('auth.login');
    }
    public function help()
    {
        return view('others.help');
    }
    public function down()
    {
        Artisan::call('down --allow=41.101.228.255/16');
    }
    public function settings()
    {
        //if (Gate::allows('is-admin', Auth::user()))
        return view('admin.settings.show');
        //else return view('patient');
    }
}
