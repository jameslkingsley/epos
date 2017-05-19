<?php

namespace App\Basket\Collections;

use App\Basket\Contracts\ItemModel;
use Illuminate\Database\Eloquent\Collection;

class ItemCollection extends Collection
{
    /**
     * Resolves all items to their models.
     * Models can run a resolution method
     * to attach any extra properties they need.
     *
     * @return ItemCollection
     */
    public function resolve()
    {
        return $this->map(function($item) {
            $model = $item->model();

            // Set the model link to be able
            // to use the model type/id in Vue
            $model->_link = $item;

            return $model;
        });
    }
}
