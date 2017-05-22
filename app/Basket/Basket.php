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
            $this->wakeup();
        }

        session()->put('basket', $this);
    }

    /**
     * Gets the item count.
     * Includes each item's quantity.
     *
     * @return integer
     */
    public function itemCount()
    {
        $itemCount = 0;

        $this->items->each(function($item) use(&$itemCount) {
            $itemCount += $item->qty;
        });

        return $itemCount;
    }

    /**
     * Gets the balance of the basket.
     *
     * @return float
     */
    public function balance()
    {
        $total = 0;

        $this->items->each(function($item) use(&$total) {
            $total += $item->qty * $item->model()->retail_price;
        });

        return number_format($total, 2);
    }

    /**
     * Wakes up the basket and sets
     * the variables up again.
     *
     * @return self
     */
    public function wakeup()
    {
        $this->itemCount = $this->itemCount();
        $this->balance = $this->balance();
        $this->vatBreakdown = $this->vatBreakdown();
        return $this;
    }

    /**
     * Gets the VAT breakdown.
     *
     * @return array
     */
    public function vatBreakdown()
    {
        $collection = $this->items->map(function($item) {
            return [
                'percentage' => $item->price()->vat,
                'net' => $item->model()->net() * $item->qty,
                'gross' => $item->model()->gross() * $item->qty
            ];
        })->groupBy('percentage');

        return $collection->map(function($vat, $key) {
            $netTotal = 0;
            $grossTotal = 0;

            foreach ($vat as $key => $value) {
                $netTotal += $value['net'];
                $grossTotal += $value['gross'];
            }

            return [
                'percentage' => (float)$vat[0]['percentage'],
                'net' => number($netTotal)->places(),
                'gross' => number($grossTotal)->places()
            ];
        });
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
