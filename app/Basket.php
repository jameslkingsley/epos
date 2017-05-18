<?php

namespace App;

use App\Accountants\General;
use App\Support\BelongsToUser;
use App\Accountants\Accountant;
use App\Basket\BasketCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use BelongsToUser;

    /**
     * Don't guard any fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['items'];

    /**
     * Basket collection.
     *
     * @var App\Basket\BasketCollection
     */
    protected $items;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Initialize a new basket collection
        $this->items = new BasketCollection;
    }

    /**
     * Get the basket collection for the basket.
     *
     * @return App\Basket\BasketCollection
     */
    public function getItemsAttribute()
    {
        return $this->items;
    }

    /**
     * Spawns a new basket instance.
     * Prepares it ready to accept
     * new items and save to storage.
     *
     * @return App\Basket
     */
    public static function spawn()
    {
        $basket = static::create([
            'user_id' => auth()->user()->id
        ]);

        // TODO

        return $basket;
    }

    /**
     * Adds the given item to the basket.
     *
     * @return this
     */
    public function add($item)
    {
        $model = $item;

        if (!$item instanceof Model) {
            $model = $item->_link->model_type::findOrFail($item->_link->model_id);
        }

        $this->items->push($model);

        return $this;
    }
}
