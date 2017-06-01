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
        $total = 0;

        $this->each(function($item) use(&$total) {
            $total += $item->net * $item->qty;
        });

        return number($total);
    }

    /**
     * Gets the total gross amount of all items.
     * Factors in their quantities.
     *
     * @return App\Basket\Support\Number
     */
    public function gross()
    {
        $total = 0;

        $this->each(function($item) use(&$total) {
            $total += $item->gross * $item->qty;
        });

        return number($total);
    }

    /**
     * Gets the total VAT amount of all items.
     * Factors in their quantities.
     *
     * @return App\Basket\Support\Number
     */
    public function vat()
    {
        $total = 0;

        $this->each(function($item) use(&$total) {
            $total += $item->vat * $item->qty;
        });

        return number($total);
    }
}
