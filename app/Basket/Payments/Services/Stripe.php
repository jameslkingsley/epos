<?php

namespace App\Basket\Payments\Services;

use App\Events\PaymentService;

class Stripe extends Service
{
    /**
     * Handles the payment service.
     *
     * @return mixed
     */
    public function handle()
    {
        // Mark the service as pending
        $this->pending();

        // Raise payment service event to
        // process it on the client-side
        event(new PaymentService($this));
    }
}
