<?php

namespace App\Listeners;

use App\Events\TransactionCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionCompletionStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $basket = basket();

        if ($basket->summaries->balance->due_from_customer <= 0) {
            event(new TransactionCompleted($basket));
        }
    }
}
