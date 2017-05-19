<?php

namespace App\Basket;

use App\Basket\Models\Item;

class Basket
{
    /**
     * Item model collection.
     *
     * @var ItemCollection
     */
    public $items = [];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($new = false)
    {
        $this->items = collect();
        $b = session('basket');

        if (!is_null($b) && !$new) {
            $this->items = collect($b->items);
        }

        session()->put('basket', $this);
    }

    /**
     * Resolves the basket instance,
     * also resolves items to their models.
     *
     * @return App\Basket\Basket
     */
    public static function resolve()
    {
        $basket = new self;

        $basket->items->map(function($item) {
            $item->model = $item->model();
            return $item;
        });

        return $basket;
    }

    /**
     * Resolves an item link to its model object.
     *
     * @return Item
     */
    public static function resolveItem($item)
    {
        return Item::findOrFail($item->_link->id);
    }

    /**
     * Adds the given item to the basket.
     *
     * @return self
     */
    public static function add($item)
    {
        $basket = new self;
        $item = $basket->resolveItem($item);

        if ($basket->has($item)) {
            // Already has item
            $basket->update($item, function(&$item) {
                $item->qty++;
            });
        } else {
            $basket->items->push($item);
        }

        return $basket;
    }

    /**
     * Groups the items by model type.
     *
     * @return Collection
     */
    public function groupedItems()
    {
        return $this->items->groupBy('model_type');
    }

    /**
     * Checks if the given item is in the basket.
     * Checks the model type and ID.
     *
     * @return boolean
     */
    public function has($item)
    {
        return $this->items->contains(function($i) use($item) {
            return $i->isSameAs($item);
        });
    }

    /**
     * Updates the given basket item with the closure.
     *
     * @return any
     */
    public function update(Item $item, $closure)
    {
        $this->items->each(function(&$i) use($item, $closure) {
            if ($i->isSameAs($item)) {
                $closure($i);
            }
        });
    }

    /**
     * Empties the basket in the session.
     * Creates a new basket, in session.
     *
     * @return App\Basket\Basket
     */
    public static function empty()
    {
        return new self(true);
    }
}
