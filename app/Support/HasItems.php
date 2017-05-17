<?php

namespace App\Support;

trait HasItems
{
    /**
     * Gets the collection of items.
     *
     * @return Collection App\Item
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
