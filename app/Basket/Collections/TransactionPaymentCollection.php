<?php

namespace App\Basket\Collections;

class TransactionPaymentCollection extends Collection
{
    /**
     * Gets the total gross amount of all payments.
     *
     * @return App\Basket\Support\Number
     */
    public function total()
    {
        return number($this->sum('amount'));
    }
}
