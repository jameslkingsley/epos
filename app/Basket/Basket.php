<?php

namespace App\Basket;

use App\Basket\Models\Item;
use Jenssegers\Model\Model;
use App\Basket\Models\Payment;
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
    const Mode_Default = 0;
    const Mode_Refund = 1;
    const Mode_Staff = 2;
    const Mode_Debug = 4;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = ['items', 'payments', 'summaries'];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($new = false)
    {
        $basket = session('basket');

        if (!is_null($basket) && !$new) {
            $this->items = $basket->items;
            $this->payments = $basket->payments;
            // $this->wakeup();
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
     * Resolves the basket instance.
     *
     * @return App\Basket\Basket
     */
    public static function resolvex()
    {
        $basket = new self;

        $basket->items->map(function($item) {
            $item->model = $item->model();
            return $item;
        });

        $basket->payments->map(function($payment) use($basket) {
            $payment->handler = $payment->getHandler($basket);
            return $payment;
        });

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
