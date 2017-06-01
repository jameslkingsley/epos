<?php

namespace App\Basket\Payments;

use App\Basket\Basket;
use App\Basket\Traits\HasConstraints;

abstract class Payment
{
    use HasConstraints;

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

    /**
     * Checks whether the item can be added to the basket.
     * If true the item can be added.
     *
     * @return boolean
     */
    public function canBeAdded(Basket $basket)
    {
        return $basket->summaries->balance->dueFromCustomer()->get() > 0;
    }
}
