<?php

namespace App;

use App\Basket\Support\Number;
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
     * @return App\Basket\Support\Number
     */
    public function net() : Number
    {
        return $this->prices()->first()->net();
    }

    /**
     * Gets the gross amount.
     * Includes VAT.
     *
     * @return App\Basket\Support\Number
     */
    public function gross() : Number
    {
        return $this->prices()->first()->gross();
    }

    /**
     * Gets the VAT amount.
     *
     * @return App\Basket\Support\Number
     */
    public function vat() : Number
    {
        return $this->prices()->first()->vat();
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
            'currency_symbol' => number()->symbol(), // TODO Use currency from env
            'model' => collect(explode('\\', get_class($this)))->last()
        ];
    }
}
