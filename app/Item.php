<?php

namespace App;

use App\Basket\ItemCollection;
use App\Support\BelongsToCategory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use BelongsToCategory;

    /**
     * Gets the resolved model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->model_type::findOrFail($this->model_id);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return App\Basket\ItemCollection
     */
    public function newCollection(array $models = [])
    {
        return new ItemCollection($models);
    }
}
