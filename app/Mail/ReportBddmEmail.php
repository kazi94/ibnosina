<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class ReportBddmEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'Rapport Banque de données médicamenteuse';
        $address ="inconnu@email.com";
        $name="Inconnu";
        
        return $this->view('emails.bddm_report')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([ 
                        'sujet'       => $this->data->report_obj,
                        'description' => $this->data->report_msg,
                    ]);
    }
}