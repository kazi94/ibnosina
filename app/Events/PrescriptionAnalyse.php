<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrescriptionAnalyse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $role;
    public $prescription_id;
    public $prescripteur;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($role, $prescription_id, $prescripteur)
    {
        $this->role            = $role;
        $this->prescription_id = $prescription_id;
        $this->prescripteur    = $prescripteur;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel');
    }
}
