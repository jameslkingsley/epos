<?php

namespace App\Basket\Traits;

trait HasItems
{
    /**
     * Gets the collection of items.
     *
     * @return Collection App\Item
     */
    public function items()
    {
        return $this->hasMany('App\Basket\Models\Item');
    }
}
