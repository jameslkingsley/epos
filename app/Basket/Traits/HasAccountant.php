<?php

namespace App\Basket\Traits;

trait HasAccountant
{
    /**
     * Gets the net amount value.
     *
     * @return flaot
     */
    public function getNetAttribute()
    {
        return $this->net();
    }

    /**
     * Gets the gross amount value.
     *
     * @return flaot
     */
    public function getGrossAttribute()
    {
        return $this->gross();
    }

    /**
     * Gets the VAT amount value.
     *
     * @return float
     */
    public function getVatAttribute()
    {
        return $this->vat();
    }

    /**
     * Gets the retail price for the model.
     * Includes the currency symbol.
     *
     * @return string
     */
    public function getRetailPriceAttribute() : string
    {
        return number($this->gross)->places(2);
    }
}
