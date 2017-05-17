<?php

namespace App\Basket;

use App\Basket\ItemModel;
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

            $model = method_exists($model, 'resolution') ? $model->resolution() : $model;

            if ($model instanceof ItemModel) {
                foreach (['title', 'price', 'meta'] as $key) {
                    $model->$key = $model->$key();
                }
            }

            return $model;
        });
    }
}
