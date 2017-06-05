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
}
