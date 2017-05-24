<?php

namespace App\Basket;

use Jenssegers\Model\Model;
use App\Basket\Models\Summary;
use App\Basket\Collections\ItemCollection;
use App\Basket\Collections\PaymentCollection;

class Basket extends Model
{
    /**
     * Basket mode constants.
     *
     * @var integer
     */
    const MDefault = 0;
    const MRefund = 1;
    const MStaff = 2;
    const MDebug = 4;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'items', 'payments', 'summaries'
    ];

    /**
     * Attributes that will be woken up when reconstructed.
     *
     * @var array
     */
    protected $wakeup = [
        'items', 'payments'
    ];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(bool $new = false)
    {
        $basket = session('basket', null);

        foreach ($this->wakeup as $attr) {
            $this->$attr = ($basket && !$new) ? $basket->$attr : [];
        }

        session()->put('basket', $this);
    }

    /**
     * Gets the basket items.
     *
     * @return App\Basket\Collections\ItemCollection
     */
    public function getItemsAttribute($items)
    {
        return $this->attributes['items'];
    }

    /**
     * Gets the basket payments.
     *
     * @return App\Basket\Collections\PaymentCollection
     */
    public function getPaymentsAttribute($payments)
    {
        return $this->attributes['payments'];
    }

    /**
     * Gets the basket summaries.
     *
     * @return App\Basket\Models\Summary
     */
    public function getSummariesAttribute()
    {
        return new Summary($this);
    }

    /**
     * Sets the basket items.
     *
     * @return void
     */
    public function setItemsAttribute($items)
    {
        $this->attributes['items'] = new ItemCollection($items);
    }

    /**
     * Sets the basket payments.
     *
     * @return void
     */
    public function setPaymentsAttribute($payments)
    {
        $this->attributes['payments'] = new PaymentCollection($payments);
    }

    /**
     * Sets the basket summaries.
     *
     * @return void
     */
    public function setSummariesAttribute($summaries)
    {
        $this->attributes['summaries'] = new Summary($summaries);
    }

    /**
     * Updates the basket in a single instance scope.
     *
     * @return self
     */
    public function update(callable $closure)
    {
        $basket = $this;

        session()->put('basket', $closure($basket));

        return $basket;
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

    /**
     * Gets the basket instance.
     *
     * @return App\Basket\Basket
     */
    public static function get()
    {
        return new self;
    }
}
