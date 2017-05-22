<?php

namespace App\Basket\Payments;

use App\Basket\Basket;
use App\Basket\Models\Payment;

class FastCash extends Cash
{
    /**
     * Computes the total payment amount.
     *
     * @return float
     */
    public function computeAmount()
    {
        return -($this->payment->amount == 0 ? $this->basket->itemBalance() : $this->payment->amount);
    }
}
