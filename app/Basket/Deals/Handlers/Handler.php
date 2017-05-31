<?php

namespace App\Basket\Deals\Handlers;

use App\Basket\Models\Deal;
use App\Basket\Traits\AutoAttributes;

abstract class Handler
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
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
        $this->basket = basket();
    }

    /**
     * Makes the class instance.
     *
     * @return any
     */
    public static function make(Deal $deal)
    {
        return new static($deal);
    }
}
