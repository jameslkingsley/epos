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
    protected $appends = [
        'amount',
        'provider',
        'serviced',
        'isServicing'
    ];

    /**
     * Amount of the payment.
     *
     * @var float
     */
    public $amount = 0;

    /**
     * Whether the payment has been serviced.
     *
     * @var boolean
     */
    public $serviced = false;

    /**
     * Whether the payment is servicing.
     *
     * @var boolean
     */
    public $isServicing = false;

    /**
     * Gets the handler instance for the payment.
     *
     * @return any
     */
    public function getProviderAttribute()
    {
        return $this->handler::make($this);
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
     * Gets the serviced flag.
     *
     * @return boolean
     */
    public function getServicedAttribute()
    {
        return $this->serviced;
    }

    /**
     * Sets the serviced flag.
     *
     * @return void
     */
    public function setServicedAttribute($value)
    {
        $this->serviced = $value;
    }

    /**
     * Gets the servicing flag.
     *
     * @return boolean
     */
    public function getIsServicingAttribute()
    {
        return $this->isServicing;
    }

    /**
     * Sets the servicing flag.
     *
     * @return void
     */
    public function setIsServicingAttribute($value)
    {
        $this->isServicing = $value;
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
