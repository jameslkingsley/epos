<?php

namespace App;

use App\Basket\Traits\HasPrices;
use App\Basket\Contracts\ItemModel;
use App\Basket\Contracts\Accountant;
use App\Basket\Traits\HasAccountant;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements Accountant, ItemModel
{
    use HasPrices,
        HasAccountant;

    /**
     * The appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'net', 'gross', 'vat',
        'title', 'retail_price', 'meta'
    ];

    /**
     * Gets the net amount.
     * Excludes VAT.
     *
     * @return float
     */
    public function net(Basket $basket = null) : float
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
    public function gross(Basket $basket = null) : float
    {
        return $this->net() + $this->vat();
    }

    /**
     * Gets the VAT amount.
     *
     * @return float
     */
    public function vat(Basket $basket = null) : float
    {
        $price = $this->prices()->first();

        return $price->trade * $price->vat;
    }

    /**
     * Gets the display title for the model.
     *
     * @return string
     */
    public function getTitleAttribute() : string
    {
        return $this->name;
    }

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function getMetaAttribute() : array
    {
        return [
            'created_at' => $this->created_at->diffForHumans(),
            'model' => collect(explode('\\', get_class($this)))->last()
        ];
    }
}
