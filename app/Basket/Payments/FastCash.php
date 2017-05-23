<?php

namespace App\Basket\Payments;

class FastCash extends Cash
{
    /**
     * Computes the total payment amount.
     *
     * @return float
     */
    public function amount($amount)
    {
        return $amount ? $amount : basket()->items->balance()->get(); // TODO Change to just outstanding overall balance
    }
}
