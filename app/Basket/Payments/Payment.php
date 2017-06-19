<?php

namespace App\Basket\Payments;

use App\Basket\Basket;

abstract class Payment
{
    /**
     * Payment instance.
     *
     * @var App\Basket\Models\Payment
     */
    protected $payment;

    /**
     * Makes a new instance.
     *
     * @return any
     */
    public static function make($model = null)
    {
        $provider = new static;

        $provider->payment = $model;

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
