<?php

namespace App\Basket\Deals;

class BuyOneGetOneHalfPrice extends Deal
{
    /**
     * Gets the items in the basket that this deal cares about.
     *
     * @return Collection App\Basket\Models\Item
     */
    public function concerns()
    {
        $dealItems = $this->deal->products();

        return $this->basket->items->reject(function($item) use($dealItems) {
            return ! $dealItems->contains($item);
        });
    }

    /**
     * Checks if the deal is eligible.
     *
     * @return boolean
     */
    public function eligible()
    {
        return $this->concerns()->isNotEmpty();
    }

    /**
     * Gets the discount value.
     *
     * @return App\Basket\Support\Number
     */
    public function discount()
    {
        $amounts = $this->concerns()->map(function($item) {
            return $item->model->gross()->cut(0.5)->times($item->qty)->inverted();
        })->all();

        return number()->sum($amounts);
    }
}
