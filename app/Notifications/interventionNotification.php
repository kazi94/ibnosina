<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\intervention;

class interventionNotification extends Notification
{
    use Queueable;

    private $intervention;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(intervention $intervention)
    {
        $this->intervention  =  $intervention;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'patient_id' => $this->intervention->patient_id,
            'prescription_id' => $this->intervention->prescription_id,
             'pharm_first_name' => $this->intervention->analyseur->name,
             'pharm_scnd_name' => $this->intervention->analyseur->prenom,
             'date_ip' => $this->intervention->date_ip
        ];
    }
}
