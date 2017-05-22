<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $divisor = 100;

    /**
     * Gets the resolved model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->model_type::findOrFail($this->model_id);
    }

    /**
     * Gets the trade price divided by the divisor.
     *
     * @return float
     */
    public function tradeDiv()
    {
        return $this->trade / $this->divisor;
    }

    /**
     * Gets the net amount.
     *
     * @return float
     */
    public function net()
    {
        return $this->tradeDiv() + ($this->markup * $this->tradeDiv());
    }

    /**
     * Gets the gross amount.
     *
     * @return float
     */
    public function gross()
    {
        return $this->net() + $this->vat();
    }

    /**
     * Gets the VAT amount.
     *
     * @return float
     */
    public function vat()
    {
        return $this->tradeDiv() * $this->vat;
    }
}
