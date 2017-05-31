<?php

namespace App\Basket\Payments;

use App\Basket\Traits\HasConstraints;

class FastCash extends Payment
{
    /**
     * Computes the total payment amount.
     *
     * @return float
     */
    public function amount($amount)
    {
        return basket()->summaries->balance->dueFromCustomer()->inverted();
    }
}
