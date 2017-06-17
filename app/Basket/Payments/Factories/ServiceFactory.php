<?php

namespace App\Basket\Payments\Factories;

use App\Basket\Models\Payment;
use App\Basket\Payments\Services\{Stripe};

class ServiceFactory
{
    /**
     * Service map.
     *
     * @var array
     */
    protected $map = [
        'stripe' => Stripe::class
    ];

    /**
     * Makes the given service class.
     *
     * @return App\Basket\Payments\Services\Service
     */
    public function make($service, Payment $payment)
    {
        if (! array_key_exists($service, $this->map)) {
            throw new Exception('Service '.$service.' does not exist');
        }

        return new $this->map[$service]($payment);
    }
}
