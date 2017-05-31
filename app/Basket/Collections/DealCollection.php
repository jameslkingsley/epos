<?php

namespace App\Basket\Collections;

use App\Basket\Models\Deal;
use App\Basket\Collections\Collection;

class DealCollection extends Collection
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
    public function __construct($deals, $basket = null)
    {
        $this->basket = $basket;

        foreach ($deals as $deal) {
            $this->push($deal);
        }
    }

    /**
     * Resolves the deal model while keeping dynamic properties.
     *
     * @return App\Basket\Models\Deal
     */
    public function resolve($deal, array $props = [])
    {
        $model = ($deal instanceof Deal) ? $deal : Deal::findOrFail($deal->id);

        foreach ($props as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }

    /**
     * Adds a deal to the collection.
     *
     * @return self
     */
    public function add($deal)
    {
        return $this->basket->update(function($basket) use($deal) {
            $deal = $basket->deals->resolve($deal);

            if ($basket->deals->has($deal)) {
                $basket->deals->update($deal, function(&$deal) {
                    $deal->qty++;
                });
            } else {
                $basket->deals->push($deal);
            }

            return $basket;
        });
    }

    /**
     * Updates the given deal via the closure.
     *
     * @return self
     */
    public function update(Deal $deal, callable $closure)
    {
        $this->each(function(&$d) use($deal, $closure) {
            if ($d->isSameAs($deal)) {
                $closure($d);
            }
        });

        return $this;
    }

    /**
     * Checks if the collection has the given deal.
     *
     * @return boolean
     */
    public function has($deal)
    {
        return $this->contains(function($d) use($deal) {
            return $d->isSameAs($deal);
        });
    }
}
