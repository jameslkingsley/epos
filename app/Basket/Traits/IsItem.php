<?php

namespace App\Basket\Traits;

use App\Basket\Traits\HasPrices;
use App\Basket\Traits\HasAccountant;
use App\Basket\Traits\HasConstraints;

trait IsItem
{
    use HasPrices,
        HasAccountant,
        HasConstraints;

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function getMetaAttribute()
    {
        return [];
    }
}
