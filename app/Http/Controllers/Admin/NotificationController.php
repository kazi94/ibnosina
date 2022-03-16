<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use DB;


class NotificationController extends Controller
{

    public function send($patient_id)
    {
        $compte = DB::table('comptes')->where('patient_id', $patient_id)->first();
        $patient = DB::table('patients')->where('id', $patient_id)->first();
        if ($compte->email != null) {
            Mail::to($compte->email)->send(new TestEmail($compte));
        }

        if ($patient->num_tel_1 != null) {
            $phone =  "213" . substr($patient->num_tel_1, 1) . "";
            $text = "Bonjour M. " . $compte->name . " C'est l'equipe technique de ANAPHARM, votre code de compte est : " . $compte->code . " .\n. ";

            $basic  = new \Nexmo\Client\Credentials\Basic('06f170bd', '5xNr7suMiyOjUuXi');
            $client = new \Nexmo\Client($basic);
            $message = $client->message()->send([
                'to' => $phone,
                'from' => 'ANAPHARM',
                'text' => $text
            ]);
        }

        return redirect(route('compte.index'));
    }
}
