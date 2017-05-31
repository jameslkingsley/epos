<?php

namespace App\Events;

use App\Events\BasketChanged;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ItemAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Item instance.
     *
     * @var App\Basket\Models\Item
     */
    protected $item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;

        event(new BasketChanged);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
