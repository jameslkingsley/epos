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
        })->reject(function($item) {
            // Reject where quantity is not a multiple of 2
            return $item->qty < 2 && $item->qty % 2 != 0;
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
        $amounts = $this->concerns()->unique(function($item) {
            return $item->model_type.':'.$item->model_id;
        })->map(function($item) {
            return $item->model->gross()->times(floor($item->qty / 2))->cut(0.5)->inverted();
        })->all();

        return number()->sum($amounts);
    }
}
