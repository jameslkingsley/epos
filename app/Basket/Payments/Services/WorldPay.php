<?php

namespace App\Basket\Payments\Services;

class WorldPay extends Service
{
    /**
     * Handles the payment service.
     *
     * @return void
     */
    public function handle()
    {
        // Mark the service as pending
        $this->pending();

        // Raise payment service event to
        // process it on the client-side
        // event(new PaymentService($this));

        $this->complete();
    }
}
