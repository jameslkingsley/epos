<?php

namespace App\Basket\Collections;

class TransactionDealCollection extends Collection
{
    /**
     * Gets the total gross amount of all deals.
     *
     * @return App\Basket\Support\Number
     */
    public function total()
    {
        return number($this->sum('discount'));
    }
}
