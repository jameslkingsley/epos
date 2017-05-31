<?php

namespace App\Basket\Deals;

use App\Basket\Deals\Handlers\Handler as Deal;

class BuyOneGetOneFree extends Deal
{
    /**
     * Checks if the deal is eligible.
     *
     * @return boolean
     */
    public function eligible()
    {
        return $this->basket->items->hasOneOf(
            $this->deal->items->resolved()
        );
    }

    /**
     * Gets the discount value.
     *
     * @return App\Basket\Support\Number
     */
    public function discount()
    {
        return number(100);
    }
}
