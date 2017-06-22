<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Basket\Payments\Services\Service;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentService implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Service instance.
     *
     * @var App\Basket\Payments\Services\Service
     */
    public $service;

    public $trace;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;

        $this->trace = traceApplicationStack();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.'.auth()->user()->id);
    }
}
