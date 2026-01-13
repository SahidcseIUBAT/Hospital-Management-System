<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel; // not used but available
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment; // will be serialized to the client
    public function __construct(Appointment $appointment)
    {
        // load relationships you want the client to receive
        $this->appointment = $appointment->load('patient.user', 'doctor.user');
    }
    public function broadcastOn()
    {
        // public channel for queue updates — change to private if you need auth
        return new Channel('appointments-queue');
    }
    public function broadcastAs()
    {
        return 'AppointmentStatusChanged';
    }
}

