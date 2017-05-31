<?php

namespace App\Basket\Collections;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class DealItemCollection extends EloquentCollection
{
    /**
     * Gets the items resolved to their models.
     *
     * @return Collection App\Basket\Models\Item
     */
    public function resolved()
    {
        return $this->map(function($dealItem) {
            return $dealItem->item;
        });
    }
}
