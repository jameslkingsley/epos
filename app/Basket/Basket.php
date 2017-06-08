<?php

namespace App\Basket;

use App\Basket\Models\Deal;
use Jenssegers\Model\Model;
use App\Events\BasketReload;
use App\Basket\Models\Summary;
use App\Events\BasketException;
use App\Events\TransactionStarted;
use Illuminate\Support\Facades\Session;
use App\Basket\Models\TransactionHeader;
use App\Basket\Collections\DealCollection;
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
    const MDebug = 3;

    /**
     * Basket flag constants.
     *
     * @var boolean
     */
    const SkipTransactionStartedEvent = true;

    /**
     * Basket mode names.
     *
     * @var array
     */
    const Modes = [
        0 => 'Default',
        1 => 'Refund',
        2 => 'Staff',
        3 => 'Debug'
    ];

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'items', 'payments',
        'summaries', 'deals',
        'modes', 'meta'
    ];

    /**
     * Attributes that will be woken up when reconstructed.
     *
     * @var array
     */
    protected $wakeup = [
        'items', 'payments',
        'deals', 'mode'
    ];

    /**
     * Default values for wakeup attributes.
     *
     * @var array
     */
    protected $wakeupDefaults = [
        'items' => [],
        'payments' => [],
        'deals' => [],
        'mode' => 0
    ];

    /**
     * Attributes that will be committed to storage.
     *
     * @var array
     */
    protected $committed = [
        'items', 'payments', 'deals'
    ];

    /**
     * Dynamic events to fire for single-instance scopes.
     *
     * @var array
     */
    protected $events = [];

    /**
     * Starting cash float in pence.
     *
     * @var integer
     */
    public $cash_float;

    /**
     * Basket mode.
     *
     * @var integer
     */
    public $mode;

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
            $this->$attr = ($basket && !$new) ? $basket->$attr : $this->wakeupDefaults[$attr];
        }

        // Static basket attributes
        $this->cash_float = config('basket.cash_float');

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
     * Gets the basket deals.
     *
     * @return App\Basket\Collections\DealCollection
     */
    public function getDealsAttribute($deals)
    {
        return $this->attributes['deals'];
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
     * Gets the basket modes.
     *
     * @return array
     */
    public function getModesAttribute()
    {
        return [
            'Default' => static::MDefault,
            'Refund' => static::MRefund,
            'Staff' => static::MStaff,
            'Debug' => static::MDebug
        ];
    }

    /**
     * Gets the basket meta data.
     *
     * @return array
     */
    public function getMetaAttribute()
    {
        return [
            'mode' => $this->mode
        ];
    }

    /**
     * Sets the basket items.
     *
     * @return void
     */
    public function setItemsAttribute($items)
    {
        $this->attributes['items'] = new ItemCollection($items, $this);
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
     * Sets the basket deals.
     *
     * @return void
     */
    public function setDealsAttribute($deals)
    {
        $this->attributes['deals'] = new DealCollection($deals, $this);
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
        $modified = $closure($this);

        if (! $modified instanceof Basket) {
            return $this;
        }

        $basket = $modified;

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
        return $this->summaries->balance->dueFromCustomer()->get() <= 0;
    }

    /**
     * Empties the basket in the session.
     * Creates a new basket, in session.
     *
     * @return App\Basket\Basket
     */
    public static function empty(bool $skip_event = false)
    {
        Session::forget('basket');

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

        return $this;
    }

    /**
     * Reloads the basket if the transaction is still open.
     *
     * @return self
     */
    public function reloadIfOpen()
    {
        if (!$this->transactionCompleted()) {
            $this->reload();
        }

        return $this;
    }

    /**
     * Checks for any deals that are eligible for adding.
     * Runs every time the basket is changed.
     *
     * @return self
     */
    public function checkForDeals()
    {
        $deals = Deal::inDate();
        $this->deals = [];

        foreach ($deals as $deal) {
            if ($deal->handler->eligible()) {
                $this->deals->add($deal);
            }
        }

        return $this;
    }

    /**
     * Closes the transaction and commits it to storage.
     *
     * @return self
     */
    public function commit()
    {
        $header = TransactionHeader::create([
            'mode' => $this->mode,
            'change_given' => $this->summaries->balance->dueToCustomer()->get()
        ]);

        foreach ($this->committed as $attr) {
            $this->$attr->commit($header);
        }

        return $this;
    }

    /**
     * Raises the basket exception event.
     *
     * @return self
     */
    public function exception($message)
    {
        if (is_null($message)) return $this;

        event(new BasketException($message));

        return $this;
    }
}
