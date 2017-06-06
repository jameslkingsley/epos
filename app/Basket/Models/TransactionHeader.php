<?php

namespace App\Basket\Models;

use App\Basket\Basket;
use App\Basket\Models\TransactionDeal;
use App\Basket\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionPayment;

class TransactionHeader extends Model
{
    /**
     * Guarded fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'net',
        'gross',
        'vat',
        'discount',
        'due_from_customer',
        'due_to_customer',
        'timestamp',
        'payment_total',
        'mode_name'
    ];

    /**
     * Gets the items for the header.
     *
     * @return Collection App\Basket\Models\TransactionItem
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Gets the payments for the header.
     *
     * @return Collection App\Basket\Models\TransactionPayment
     */
    public function payments()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    /**
     * Gets the deals for the header.
     *
     * @return Collection App\Basket\Models\TransactionDeal
     */
    public function deals()
    {
        return $this->hasMany(TransactionDeal::class);
    }

    /**
     * Gets the net amount of the transaction.
     *
     * @return App\Basket\Support\Number
     */
    public function net()
    {
        return $this->items->net();
    }

    /**
     * Gets the gross amount of the transaction.
     *
     * @return App\Basket\Support\Number
     */
    public function gross()
    {
        return $this->items->gross();
    }

    /**
     * Gets the VAT amount of the transaction.
     *
     * @return App\Basket\Support\Number
     */
    public function vat()
    {
        return $this->items->vat();
    }

    /**
     * Gets the total amount due from the customer.
     *
     * @return App\Basket\Support\Number
     */
    public function dueFromCustomer()
    {
        return number()->sum(
            $this->items->gross(),
            $this->deals->total()
        );
    }

    /**
     * Gets the total amount due to the customer.
     *
     * @return App\Basket\Support\Number
     */
    public function dueToCustomer()
    {
        return number($this->change_given);
    }

    /**
     * Gets the payment total given by the customer.
     *
     * @return App\Basket\Support\Number
     */
    public function paymentTotal()
    {
        return $this->payments->total();
    }

    /**
     * Gets the total discount amount of the transaction.
     *
     * @return App\Basket\Support\Number
     */
    public function discount()
    {
        return number($this->deals->sum('discount'));
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getNetAttribute()
    {
        return $this->net()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getGrossAttribute()
    {
        return $this->gross()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getVatAttribute()
    {
        return $this->vat()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getDiscountAttribute()
    {
        return $this->discount()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getDueFromCustomerAttribute()
    {
        return $this->dueFromCustomer()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getDueToCustomerAttribute()
    {
        return $this->dueToCustomer()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getPaymentTotalAttribute()
    {
        return $this->paymentTotal()->inverted()->get();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getTimestampAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getModeNameAttribute()
    {
        return Basket::Modes[$this->mode];
    }
}
