<?php

namespace App\Basket\Models;

use App\Basket\Models\Item;
use Illuminate\Database\Eloquent\Model;
use App\Basket\Collections\DealItemCollection;

class DealItem extends Model
{
    /**
     * Gets the item model.
     *
     * @return App\Basket\Models\Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\DealItemCollection
     */
    public function newCollection(array $models = [])
    {
        return new DealItemCollection($models);
    }
}
