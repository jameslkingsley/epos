<?php

namespace App\Basket\Deals;

class BuyOneGetOneHalfPrice extends BuyOneGetOneFree
{
    /**
     * Gets the discount value.
     *
     * @return App\Basket\Support\Number
     */
    public function discount()
    {
        return number()->sum(
            $this->concernsUnique()->map(function($item) {
                return $item->model->gross()->times(floor($item->qty / 2))->cut(0.5)->inverted();
            })->all()
        );
    }
}
