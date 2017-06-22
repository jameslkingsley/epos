<?php

namespace App\Basket\Payments;

use App\Basket\Payments\Contracts\Servicable;
use App\Basket\Payments\Factories\ServiceFactory;

class Card extends Payment implements Servicable
{
    /**
     * Gets the service provider for the payment.
     *
     * @return App\Basket\Payments\Services\Service
     */
    public function service()
    {
        return $this->factory->make(
            setting('payment:card:service', 'stripe'),
            $this->payment
        );
    }
}
