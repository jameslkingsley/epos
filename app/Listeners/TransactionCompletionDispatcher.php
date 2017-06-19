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
        // If all payments have been serviced,
        // commit the transaction, otherwise run services
        if (basket()->payments->serviced()) {
            // Close the basket transaction
            // and commits it to storage.
            basket()->commit();

            // Empty the basket ready for a new transaction
            // Skips the new basket event, to prevent
            // overwriting basket view on front-end
            basket()->empty(Basket::SkipTransactionStartedEvent);
        } else {
            // Process any payment services such as Stripe
            $payments = basket()->payments->servicable()->reject(function($p) {
                return $p->serviced || $p->isServicing;
            });

            foreach ($payments as $payment) {
                if ($service = $payment->provider->service()) {
                    $service->handle();
                }
            }

            // If services are now all complete,
            // call handle again to commit the basket
            if (basket()->payments->serviced()) {
                $this->handle($event);
            }
        }
    }
}
