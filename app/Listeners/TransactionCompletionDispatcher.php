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
        // Process any payment services such as Stripe
        foreach (basket()->payments as $payment) {
            if ($service = $payment->provider->service()) {
                $service->handle();
            }
        }

        // If all payments have been serviced,
        // commit the transaction, otherwise exit
        if (! basket()->payments->serviced()) return;

        // Close the basket transaction
        // and commits it to storage.
        basket()->commit();

        // Empty the basket ready for a new transaction
        // Skips the new basket event, to prevent
        // overwriting basket view on front-end
        basket()->empty(Basket::SkipTransactionStartedEvent);
    }
}
