<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdvertisementUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $device_id;
    public $advertisement_id;

    /**
     * Create a new event instance.
     *
     * @param $device_id
     * @param $advertisement_id
     */
    public function __construct($device_id, $advertisement_id)
    {
        $this->device_id = $device_id;
        $this->advertisement_id = $advertisement_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('device.'.$this->device_id);
    }
}
