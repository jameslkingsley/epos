<?php

namespace App\Basket\Payments;

use App\Basket\Payments\Contracts\Servicable;
use App\Basket\Payments\Factories\ServiceFactory;

class Card extends Payment implements Servicable
{
    /**
     * Gets the service provider for the payment.
     *
     * @return App\Basket\Payments\Services\Service | null
     */
    public function service()
    {
        $service = setting('payment:card:service', 'stripe');

        // If no service provided, exit
        if (! $service) return null;

        return (new ServiceFactory)->make($service, $this->payment);
    }
}
