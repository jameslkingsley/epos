<?php

namespace App\Basket\Collections;

use App\Basket\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemCollection extends Collection
{
    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($items)
    {
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
     * Adds an item to the collection.
     *
     * @return self
     */
    public function add($item)
    {
        $item = ($item instanceof Item) ? $item : Item::findOrFail($item->id);

        if ($this->has($item)) {
            $this->update($item, function(&$item) {
                $item->qty++;
            });
        } else {
            $this->push($item);
        }

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
