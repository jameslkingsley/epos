<?php

namespace App\Listeners;

use App\Events\BasketChanged;
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
    public function handle(BasketChanged $event)
    {
        $basket = basket();

        if ($basket->transactionCompleted()) {
            event(new TransactionCompleted($basket));
        }
    }
}
