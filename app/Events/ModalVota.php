<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ModalVota implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data)
    {
        Log::info('Evento ModalVota disparado!');
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('modal-channel');
    }

    public function broadcastAs()
    {
        return 'ModalVota';
    }
}
 
