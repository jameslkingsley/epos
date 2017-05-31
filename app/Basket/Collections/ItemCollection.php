<?php

namespace App\Basket\Collections;

use App\Events\ItemAdded;
use App\Basket\Models\Item;
use App\Events\BasketException;
use App\Basket\Exceptions\Exception;
use App\Basket\Collections\Collection;

class ItemCollection extends Collection
{
    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($items, $basket = null)
    {
        $this->basket = $basket;

        foreach ($items as $item) {
            $this->push($item);
        }
    }

    /**
     * Gets the count of all items.
     * Factors in each item's quantity.
     *
     * @return integer
     */
    public function count()
    {
        $count = 0;

        $this->each(function($item) use(&$count) {
            $count += $item->qty;
        });

        return $count;
    }

    /**
     * Gets the balance of all items.
     *
     * @return App\Basket\Support\Number
     */
    public function balance()
    {
        $total = 0;

        $this->each(function($item) use(&$total) {
            $total += $item->qty * $item->model->gross;
        });

        return number($total);
    }

    /**
     * Checks if the collection has the given item.
     *
     * @return boolean
     */
    public function has($item)
    {
        return $this->contains(function($i) use($item) {
            return $i->isSameAs($item);
        });
    }

    /**
     * Checks if the collection has one of the given items.
     *
     * @return boolean
     */
    public function hasOneOf($items)
    {
        return $this->contains(function($i) use($items) {
            return $items->contains(function($ii) use($i) {
                return $ii->isSameAs($i);
            });
        });
    }

    /**
     * Resolves the item model while keeping dynamic properties.
     *
     * @return App\Basket\Models\Item
     */
    public function resolve($item, array $props = [])
    {
        $model = ($item instanceof Item) ? $item : Item::findOrFail($item->id);

        foreach ($props as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }

    /**
     * Validates the item to check if it can be added.
     *
     * @throws App\Events\BasketException
     * @return void
     */
    public function validate(Item $item)
    {
        try {
            $item->model->canBeAdded($this->basket);
        } catch(Exception $e) {
            event(new BasketException($e->getMessage()));
            exit;
        }
    }

    /**
     * Adds an item to the collection.
     *
     * @return self
     */
    public function add($item)
    {
        $item = $this->resolve($item);

        // Validate the item
        // If invalid, will exit
        $this->validate($item);

        if ($this->has($item)) {
            $this->update($item, function(&$item) {
                $item->qty++;
            });
        } else {
            $this->push($item);
        }

        event(new ItemAdded($item));

        return $this;
    }

    /**
     * Removes the given item from the collection.
     *
     * @return self
     */
    public function remove(Item $item, int $qty = -1)
    {
        $this->items = $this->map(function($i) use($item, $qty) {
            if ($i->isSameAs($item)) {
                if ($qty === -1 || $i->qty <= 1) {
                    return null;
                }

                $i->qty -= $qty;
                return $i;
            }
        })->reject(function($i) {
            return is_null($i);
        })->all();
    }

    /**
     * Updates the given item via the closure.
     *
     * @return self
     */
    public function update(Item $item, callable $closure)
    {
        $this->each(function(&$i) use($item, $closure) {
            if ($i->isSameAs($item)) {
                $closure($i);
            }
        });

        return $this;
    }

    /**
     * Gets the items grouped by the given column.
     *
     * @return self
     */
    public function grouped(string $column = 'model_type')
    {
        return $this->groupBy($column);
    }
}
