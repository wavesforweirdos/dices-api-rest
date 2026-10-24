<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerThrowsDices
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $dice1;
    public $dice2;
    public $result;
    public function __construct($id, $dice1, $dice2)
    {
        $this->id = $id;
        $this->dice1 = $dice1;
        $this->dice2 = $dice2;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
