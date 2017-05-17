<?php

namespace App\Support;

use App\Price;

trait HasPrices
{
    /**
     * Gets the collection of prices.
     *
     * @return Collection App\Price
     */
    public function prices()
    {
        return Price::where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
