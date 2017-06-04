<?php

namespace App\Basket\Traits;

use App\Basket\Models\Price;
use App\Basket\Support\Number;

trait HasPrices
{
    /**
     * Gets the collection of prices.
     *
     * @return Collection App\Basket\Models\Price
     */
    public function prices()
    {
        return Price::where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Gets the latest price record.
     *
     * @return App\Basket\Models\Price
     */
    public function price()
    {
        return $this->prices()->first();
    }

    /**
     * Gets the net amount.
     * Excludes VAT.
     *
     * @return App\Basket\Support\Number
     */
    public function net() : Number
    {
        return $this->price()->net();
    }

    /**
     * Gets the gross amount.
     * Includes VAT.
     *
     * @return App\Basket\Support\Number
     */
    public function gross() : Number
    {
        return $this->price()->gross();
    }

    /**
     * Gets the VAT amount.
     *
     * @return App\Basket\Support\Number
     */
    public function vat() : Number
    {
        return $this->price()->vat();
    }

    /**
     * Gets the net amount value.
     *
     * @return integer
     */
    public function getNetAttribute()
    {
        return $this->net()->get();
    }

    /**
     * Gets the gross amount value.
     *
     * @return integer
     */
    public function getGrossAttribute()
    {
        return $this->gross()->get();
    }

    /**
     * Gets the VAT amount value.
     *
     * @return integer
     */
    public function getVatAttribute()
    {
        return $this->vat()->get();
    }
}
