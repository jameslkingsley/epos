<?php

namespace App\Basket\Constraints;

use App\Basket\Basket;

class ItemConstraint extends Constraint
{
    /**
     * Checks if the constraint passes.
     *
     * @return boolean
     */
    public function passes(Basket $basket, $item)
    {
        $this->basket = $basket;
        $this->item = $item;

        return true;
    }
}
