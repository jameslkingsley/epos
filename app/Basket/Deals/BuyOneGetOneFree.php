<?php

namespace App\Basket\Deals;

class BuyOneGetOneFree extends Deal
{
    /**
     * Gets the items in the basket that this deal cares about.
     *
     * @return Collection App\Basket\Models\Item
     */
    public function concerns()
    {
        return $this->productsInBasket()->reject(function($item) {
            // Reject where quantity is not a multiple of 2
            return $item->qty < 2 && $item->qty % 2 != 0;
        });
    }

    /**
     * Gets the discount value.
     *
     * @return App\Basket\Support\Number
     */
    public function discount()
    {
        return number()->sum(
            $this->concernsUnique()->map(function($item) {
                return $item->model->gross()->times(floor($item->qty / 2))->inverted();
            })->all()
        );
    }
}
