<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * Gets the resolved model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->hasOne($this->model_type, 'id', 'model_id');
    }

    /**
     * Gets the net amount.
     *
     * @return App\Basket\Support\Number
     */
    public function net()
    {
        return number($this->trade * ($this->markup + 1))->round();
    }

    /**
     * Gets the gross amount.
     *
     * @return App\Basket\Support\Number
     */
    public function gross()
    {
        return number()->sum(
            number($this->trade * ($this->markup + 1)),
            number($this->trade * $this->vat)
        )->round();
    }

    /**
     * Gets the VAT amount.
     *
     * @return App\Basket\Support\Number
     */
    public function vat()
    {
        return number($this->trade * $this->vat)->round();
    }
}
