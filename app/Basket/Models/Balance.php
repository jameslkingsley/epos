<?php

namespace App\Basket\Models;

use App\Basket\Basket;
use Jenssegers\Model\Model;
use App\Basket\Traits\AutoAttributes;

class Balance extends Model
{
    use AutoAttributes;

    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'due_from_customer',
        'due_to_customer',
        'items'
    ];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    /**
     * Gets the balance due from the customer.
     * Factors in payments.
     *
     * @return App\Basket\Support\Number
     */
    public function dueFromCustomer()
    {
        return number()->sum(
            $this->basket->items->balance(),
            $this->basket->payments->balance()
        );
    }

    /**
     * Gets the balance due to the customer.
     *
     * @return App\Basket\Support\Number
     */
    public function dueToCustomer()
    {
        return number($this->dueFromCustomer()->inverted());
    }

    /**
     * Gets the balance for just items.
     *
     * @return App\Basket\Support\Number
     */
    public function items()
    {
        return $this->basket->items->balance();
    }
}
