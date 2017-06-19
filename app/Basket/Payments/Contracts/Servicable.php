<?php

namespace App\Basket\Payments\Contracts;

interface Servicable
{
    /**
     * Gets the service provider for the payment.
     *
     * @return App\Basket\Payments\Services\Service
     */
    public function service();
}
