<?php

namespace App\Support;

trait HasPrices
{
    /**
     * Gets the collection of prices.
     *
     * @return Collection App\Price
     */
    public function prices()
    {
        return $this->hasMany('App\Price');
    }
}
