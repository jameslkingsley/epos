<?php

namespace App\Basket\Payments;

use App\Basket\Basket;
use App\Basket\Payments\Contracts\Servicable;
use App\Basket\Payments\Factories\ServiceFactory;

abstract class Payment
{
    /**
     * Payment instance.
     *
     * @var App\Basket\Models\Payment
     */
    protected $payment;

    /**
     * Service factory instance.
     *
     * @var App\Basket\Payments\Factories\ServiceFactory
     */
    protected $factory;

    /**
     * Makes a new instance.
     *
     * @return any
     */
    public static function make($model = null)
    {
        $provider = new static;

        $provider->payment = $model;

        if ($provider instanceof Servicable) {
            $provider->factory = new ServiceFactory;
        }

        return $provider;
    }

    /**
     * Computes the total payment amount.
     *
     * @return float
     */
    public function amount($amount)
    {
        return number($amount)->inverted()->get();
    }
}
