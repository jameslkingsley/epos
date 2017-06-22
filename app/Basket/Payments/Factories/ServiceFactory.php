<?php

namespace App\Basket\Payments\Factories;

use App\Basket\Models\Payment;
use App\Basket\Exceptions\Exception;

class ServiceFactory
{
    /**
     * Makes the given service class.
     *
     * @return App\Basket\Payments\Services\Service
     */
    public function make($service, Payment $payment)
    {
        $map = config('services.payments');

        if (! array_key_exists($service, $map)) {
            throw new Exception('Service '.$service.' does not exist');
        }

        return new $map[$service]($payment);
    }
}
