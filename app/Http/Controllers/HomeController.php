<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\InjectionController;
use App\Http\Controllers\User\BilanController;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inj = new InjectionController;
        $dem = new BilanController;
        $res = $inj->getAdministrations();
        $res1 = $dem->getDemandes('Exam in progress');
        $countInj = "";
        $countAnal = "";
        $countDem = count($res1);
        foreach ($res as $prescription)
            if (isset($prescription->patient->hospi))
                if (date('Y-m-d') <= $prescription->lastDate)
                    $countInj++;
        if (Auth::user()->notifications)
            foreach (Auth::user()->unreadNotifications as $notification)
                if ($notification->type == 'App\Notifications\analyseNotification')
                    $countAnal++;


        return view('home', compact('countInj', 'countDem', 'countAnal'));
    }

    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('admin.logs.show', compact('logs'));
    }
}
