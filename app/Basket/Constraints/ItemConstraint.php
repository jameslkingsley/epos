<?php

namespace App\Basket\Constraints;

use App\Basket\Basket;

class ItemConstraint extends Constraint
{
    /**
     * Checks if the item can be added.
     *
     * @return boolean
     */
    public function adding()
    {
        return true;
    }
}
