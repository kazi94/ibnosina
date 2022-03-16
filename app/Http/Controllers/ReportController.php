<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportEmail;
use App\Mail\ReportBddmEmail;
use DB;
use App\User;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function bugs()
    {
        return view('bugs');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportBug(Request $request)
    {
        $nom = $request->nom;
        $sujet = $request->sujet;
        $description = $request->description;
        //Store Image in images/bugs folder

        $path = $request->photo ? $request->file('photo')->store('bugs') : 'bugs/';
        $request->photo = $path;
        Mail::to("support@medicaments.hic-sante.com")->send(new ReportEmail($request));

        // $phone =  "2130781714511";
        // $text = $description;

        // $basic  = new \Nexmo\Client\Credentials\Basic('3e669b93', 'wuelj9M0FSTvAiim');
        // $client = new \Nexmo\Client($basic);
        //     $message = $client->message()->send([
        //     'to' => $phone,
        //     'from' => 'ANAPHARM',
        //     'text' => $text
        // ]);
        return redirect(route('home'))->with('message', 'Rapport envoyer avec succées');
    }

    public function bddmReport(Request $request)
    {
        $sujet = $request->report_obj;
        $description = $request->report_msg;

        Mail::to("support@medicaments.hic-sante.com")->send(new ReportBddmEmail($request));
    }
}
