<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = Auth::user()->email;
        $subject = 'Rapport de bugs';
        $name = Auth::user()->name . " " . Auth::user()->prenom;
        if (isset($this->data->connected))
            return $this->view('emails.bugs_report')
                ->from($address, $name)
                ->subject('Nouvelle connection')
                ->with([
                    'nom'         =>  $this->data->name,
                    'sujet'       => $this->data->current_login,
                    'description' => 'gdfgdfgfd',
                    'photo'       => 'gfdgfdgfd',
                ]);
        else
            return $this->view('emails.bugs_report')
                ->from($address, $name)
                ->subject($subject)
                ->attachFromStorage($this->data->photo)
                ->with([
                    'nom'         =>  $this->data->nom,
                    'sujet'       => $this->data->sujet,
                    'description' => $this->data->description,
                    'photo'       => $this->data->photo,
                ]);
    }
}
