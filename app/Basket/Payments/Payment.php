<?php

namespace App\Basket\Payments;

use App\Basket\Basket;

abstract class Payment
{
    /**
     * Makes a new instance.
     *
     * @return any
     */
    public static function make()
    {
        return new static;
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
