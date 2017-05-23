<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use App\Basket\Collections\PaymentCollection;

class Payment extends Model
{
    /**
     * The appendable attributes.
     *
     * @var array
     */
    protected $appends = ['amount', 'handler_class'];

    /**
     * Amount of the payment.
     *
     * @var float
     */
    public $amount = 0;

    /**
     * Gets the handler instance for the payment.
     *
     * @return any
     */
    public function getHandlerAttribute($handler)
    {
        return new $handler;
    }

    /**
     * Gets the handler class for the payment.
     *
     * @return string
     */
    public function getHandlerClassAttribute()
    {
        return get_class($this->handler);
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

    /**
     * Checks if the given payment model
     * is the same type and ID.
     *
     * @return boolean
     */
    public function isSameAs(Payment $payment)
    {
        return $this->id == $payment->id;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\PaymentCollection
     */
    public function newCollection(array $models = [])
    {
        return new PaymentCollection($models);
    }
}
