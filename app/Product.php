<?php

namespace App;

use App\Basket\ItemModel;
use App\Basket\Accountant;
use App\Support\HasPrices;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements Accountant, ItemModel
{
    use HasPrices;

    /**
     * Gets the resolution version of the model.
     *
     * @return App\Product
     */
    public function resolution()
    {
        return $this;
    }

    /**
     * Gets the net amount.
     * Excludes VAT.
     *
     * @return float
     */
    public function net(Basket $basket = null)
    {
        $price = $this->prices()->first();

        return $price->trade + ($price->markup * $price->trade);
    }

    /**
     * Gets the gross amount.
     * Includes VAT.
     *
     * @return float
     */
    public function gross(Basket $basket = null)
    {
        return $this->net() + $this->vat();
    }

    /**
     * Gets the VAT amount.
     *
     * @return float
     */
    public function vat(Basket $basket = null)
    {
        $price = $this->prices()->first();

        return $price->trade * $price->vat;
    }

    /**
     * Gets the display title for the model.
     *
     * @return string
     */
    public function title()
    {
        return $this->name;
    }

    /**
     * Gets the retail price for the model.
     *
     * @return float
     */
    public function price()
    {
        return number_format($this->gross(), 2);
    }

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function meta()
    {
        $class = collect(explode('\\', get_class($this)))->last();

        return [
            'created_at' => "{$this->created_at->diffForHumans()} | {$class}"
        ];
    }
}
