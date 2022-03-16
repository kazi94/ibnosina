<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class PharmacieController extends Controller
{
 
    public function index()
    {
        if (Auth::user()->cant('peut-analyser')) return redirect()->back();
        $countAnal = "";
        if (Auth::user()->notifications)
            foreach (Auth::user()->unreadNotifications as $notification)
                if ($notification->type == 'App\Notifications\analyseNotification')
                    $countAnal++;
        
        return view('user.pharmacien.show' , compact('countAnal'));
    }

}
