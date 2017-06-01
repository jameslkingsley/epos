<?php

namespace App\Basket\Models;

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
        'net', 'gross',
        'vat', 'discount'
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
        return $this->net()->normal()->display();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getGrossAttribute()
    {
        return $this->gross()->normal()->display();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getVatAttribute()
    {
        return $this->vat()->normal()->display();
    }

    /**
     * Gets the attributable version.
     *
     * @return any
     */
    public function getDiscountAttribute()
    {
        return $this->discount()->normal()->display();
    }
}
