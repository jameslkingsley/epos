<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Basket\Models\TransactionHeader;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrintReceipt implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Transaction header.
     *
     * @var App\Basket\Models\TransactionHeader
     */
    public $transaction;

    /**
     * Client printer setting value.
     *
     * @var string
     */
    public $printer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($header)
    {
        if (!$header) return;

        $this->transaction = $header;

        $printerParts = explode('\\', setting('peripheral:printer'));
        $this->printer = array_pop($printerParts);
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
