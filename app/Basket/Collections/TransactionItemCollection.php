<?php

namespace App\Basket\Collections;

class TransactionItemCollection extends Collection
{
    /**
     * Gets the total net amount of all items.
     * Factors in their quantities.
     *
     * @return App\Basket\Support\Number
     */
    public function net()
    {
        return number($this->sum(function($item) {
            return $item->net * $item->qty;
        }));
    }

    /**
     * Gets the total gross amount of all items.
     * Factors in their quantities.
     *
     * @return App\Basket\Support\Number
     */
    public function gross()
    {
        return number($this->sum(function($item) {
            return $item->gross * $item->qty;
        }));
    }

    /**
     * Gets the total VAT amount of all items.
     * Factors in their quantities.
     *
     * @return App\Basket\Support\Number
     */
    public function vat()
    {
        return number($this->sum(function($item) {
            return $item->vat * $item->qty;
        }));
    }
}
