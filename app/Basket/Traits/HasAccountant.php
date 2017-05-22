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
     *
     * @return float
     */
    public function getRetailPriceAttribute() : float
    {
        return number_format($this->gross, 2);
    }
}
