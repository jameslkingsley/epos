<?php

namespace App\Basket\Traits;

trait HasAccountant
{
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

    /**
     * Gets the retail price for the model.
     * Includes the currency symbol.
     *
     * @return string
     */
    public function getRetailPriceAttribute() : string
    {
        return number($this->gross)->normal()->places(2);
    }
}
