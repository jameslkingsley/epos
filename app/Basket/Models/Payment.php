<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Amount of the payment.
     *
     * @var float
     */
    public $amount = 0;

    /**
     * Payment instance.
     *
     * @var App\Basket\Models\Payment
     */
    protected $payment;

    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * The appendable attributes.
     *
     * @var array
     */
    protected $appends = ['amount'];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($payment = null, $basket = null)
    {
        $this->payment = $payment;
        $this->basket = $basket;
    }

    /**
     * Gets the handler class for the payment.
     *
     * @return any
     */
    public function getHandler($basket = null)
    {
        return new $this->handler($this, $basket);
    }

    /**
     * Computes the payment via its handler.
     *
     * @return self
     */
    public function compute()
    {
        $this->amount = $this->getHandler($basket)->computeAmount();
    }

    /**
     * Gets the amount value.
     *
     * @return float
     */
    public function getAmountAttribute()
    {
        return $this->amount;
    }
}
