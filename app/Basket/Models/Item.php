<?php

namespace App\Basket\Models;

use App\Support\BelongsToCategory;
use Illuminate\Database\Eloquent\Model;
use App\Basket\Collections\ItemCollection;

class Item extends Model
{
    use BelongsToCategory;

    /**
     * The appendable attributes.
     *
     * @var array
     */
    protected $appends = ['qty'];

    /**
     * Adhoc quantity value.
     *
     * @var integer
     */
    public $qty = 1;

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
     * Checks if the given item model
     * is the same type and ID.
     *
     * @return boolean
     */
    public function isSameAs(Item $item)
    {
        return $this->model_type == $item->model_type &&
               $this->model_id == $item->model_id;
    }

    /**
     * Gets the quantity value.
     *
     * @return integer
     */
    public function getQtyAttribute()
    {
        return $this->qty;
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
