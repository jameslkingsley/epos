<?php

namespace App\Basket\Deals;

use App\Basket\Models\Deal as DealModel;
use App\Basket\Traits\AutoAttributes;

abstract class Deal
{
    use AutoAttributes;

    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Deal instance.
     *
     * @var App\Basket\Models\Deal
     */
    protected $deal;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(DealModel $deal)
    {
        $this->deal = $deal;
        $this->basket = basket();
    }

    /**
     * Makes the class instance.
     *
     * @return any
     */
    public static function make(DealModel $deal)
    {
        return new static($deal);
    }

    /**
     * Checks if the deal is eligible.
     *
     * @return boolean
     */
    public function eligible()
    {
        return $this->concerns()->isNotEmpty();
    }

    /**
     * Gets the products in basket that are in the deal.
     *
     * @return Collection App\Basket\Models\Item
     */
    public function productsInBasket()
    {
        $dealItems = $this->deal->products();

        return $this->basket->items->reject(function($item) use($dealItems) {
            return ! $dealItems->contains($item);
        });
    }

    /**
     * Gets the unique concerned items.
     *
     * @return Collection App\Basket\Models\Item
     */
    public function concernsUnique()
    {
        return $this->concerns()->unique(function($item) {
            return $item->model_type.':'.$item->model_id;
        });
    }
}
