<?php

namespace App\Basket\Models;

use App\Basket\Models\Deal;
use Illuminate\Database\Eloquent\Model;
use App\Basket\Models\TransactionHeader;
use App\Basket\Traits\BelongsToTransactionHeader;
use App\Basket\Collections\TransactionDealCollection;

class TransactionDeal extends Model
{
    use BelongsToTransactionHeader;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'discount_total',
        'title'
    ];

    /**
     * Guarded fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Gets the deal instance.
     *
     * @return App\Basket\Models\Deal
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    /**
     * Gets the discount title attribute.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->deal->name;
    }

    /**
     * Gets the discount total attribute.
     *
     * @return string
     */
    public function getDiscountTotalAttribute()
    {
        return number($this->discount)->normal()->display();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return App\Basket\Collections\TransactionDealCollection
     */
    public function newCollection(array $models = [])
    {
        return new TransactionDealCollection($models);
    }
}
