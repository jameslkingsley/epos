<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BasketChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    public $basket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->basket = basket();
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