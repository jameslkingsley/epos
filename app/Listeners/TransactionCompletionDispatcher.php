<?php

namespace App\Listeners;

use App\Basket\Basket;
use App\Events\TransactionCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionCompletionDispatcher
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
     * @param  TransactionCompleted  $event
     * @return void
     */
    public function handle(TransactionCompleted $event)
    {
        // Close the basket transaction
        // and commits it to storage.
        basket()->commit();

        // Empty the basket ready for a new transaction
        // Skips the new basket event, to prevent
        // overwriting basket view on front-end
        basket()->empty(Basket::SkipTransactionStartedEvent);
    }
}
