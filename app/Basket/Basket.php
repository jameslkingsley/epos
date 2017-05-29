<?php

namespace App\Basket;

use Jenssegers\Model\Model;
use App\Events\BasketReload;
use App\Basket\Models\Summary;
use App\Events\TransactionStarted;
use App\Basket\Collections\ItemCollection;
use Illuminate\Database\Eloquent\Collection;
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
     * Basket flag constants.
     *
     * @var integer
     */
    const SkipTransactionStartedEvent = true;

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
     * Dynamic events to fire for single-instance scopes.
     *
     * @var array
     */
    protected $events = [];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(bool $new = false, bool $skip_event = false)
    {
        // Empty the events, make it a collection
        $this->events = collect([]);

        $basket = session('basket', null);

        foreach ($this->wakeup as $attr) {
            $this->$attr = ($basket && !$new) ? $basket->$attr : [];
        }

        session()->put('basket', $this);

        if ($new && !$skip_event) {
            event(new TransactionStarted($this));
        }
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
        $this->attributes['payments'] = new PaymentCollection($payments, $this);
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
     * Adds an event to the basket.
     *
     * @return self
     */
    public function withEvent(string $name, $args)
    {
        $this->events->push([
            'name' => $name,
            'args' => $args
        ]);

        return $this;
    }

    /**
     * Updates the basket in a single instance scope.
     *
     * @return self
     */
    public function update(callable $closure)
    {
        $basket = $closure($this);

        session()->put('basket', $basket);

        // Call any dynamic events added to the basket
        $basket->events->each(function($event) {
            event(new $event['name']($event['args']));
        });

        return $basket;
    }

    /**
     * Checks whether the transaction is completed.
     *
     * @return boolean
     */
    public function transactionCompleted()
    {
        return $this->summaries->balance->due_from_customer <= 0;
    }

    /**
     * Empties the basket in the session.
     * Creates a new basket, in session.
     *
     * @return App\Basket\Basket
     */
    public static function empty(bool $skip_event = false)
    {
        return new self(true, $skip_event);
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

    /**
     * Raises the reload basket event.
     *
     * @return self
     */
    public function reload()
    {
        event(new BasketReload($this));
    }
}
