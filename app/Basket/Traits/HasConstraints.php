<?php

namespace App\Basket\Traits;

use App\Basket\Basket;
use App\Basket\Exceptions\Exception;

trait HasConstraints
{
    /**
     * Checks whether the item can be added to the basket.
     * If true the item can be added.
     *
     * @return boolean
     */
    public function canBeAdded(Basket $basket)
    {
        return true;
    }
}
