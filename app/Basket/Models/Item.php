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
    protected $appends = ['qty', 'amount', 'title', 'model'];

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
    public function getModelAttribute()
    {
        return $this->model_type::findOrFail($this->model_id);
    }

    /**
     * Gets the price of the model.
     * Uses the latest price record.
     * Returns null if no price found.
     *
     * @return App\Basket\Models\Price
     */
    public function price()
    {
        return $this->model->prices()->first();
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
     * Gets the amount value as string.
     *
     * @return string
     */
    public function getAmountAttribute()
    {
        return number($this->qty * $this->model->gross)->display();
    }

    /**
     * Gets the title of the item.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->model->title;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\ItemCollection
     */
    public function newCollection(array $models = [])
    {
        return new ItemCollection($models);
    }
}
