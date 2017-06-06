<?php

namespace App\Basket\Models;

use Carbon\Carbon;
use App\Basket\Models\DealItem;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    /**
     * The appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'handler', 'discount'
    ];

    /**
     * Gets the deal items.
     *
     * @return Collection App\Basket\Models\DealItem
     */
    public function items()
    {
        return $this->hasMany(DealItem::class);
    }

    /**
     * Gets the discount from the handler.
     *
     * @return App\Basket\Support\Number
     */
    public function getDiscountAttribute()
    {
        return $this->handler->discount()->get();
    }

    /**
     * Gets the items resolved to their models.
     *
     * @return any
     */
    public function products()
    {
        return $this->items->resolved();
    }

    /**
     * Gets the handler instance.
     *
     * @return any
     */
    public function getHandlerAttribute()
    {
        return $this->handler_class::make($this);
    }

    /**
     * Gets all deals that are in date.
     *
     * @return Collection App\Basket\Models\Deal
     */
    public static function inDate()
    {
        return static::where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now())
            ->orderBy('starts_at', 'desc')
            ->get();
    }

    /**
     * Checks if the given deal model is the same.
     *
     * @return boolean
     */
    public function isSameAs(Deal $deal)
    {
        return $this->id == $deal->id;
    }

    /**
     * Check if the item has any deals in date.
     *
     * @return boolean
     */
    public static function eligibleFor(Item $item)
    {
        return static::inDate()->contains(function($deal) use($item) {
            return $deal->items->contains('item_id', $item->id);
        });
    }
}
