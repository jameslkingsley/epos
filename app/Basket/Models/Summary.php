<?php

namespace App\Basket\Models;

use App\Basket\Basket;
use Jenssegers\Model\Model;
use App\Basket\Models\Balance;

class Summary extends Model
{
    /**
     * Basket instance.
     *
     * @var App\Basket\Basket
     */
    protected $basket;

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = ['balance', 'vat'];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    /**
     * Gets the basket balance instance.
     *
     * @return App\Basket\Models\Balance
     */
    public function getBalanceAttribute()
    {
        return new Balance($this->basket);
    }

    /**
     * Gets the VAT breakdown of the basket.
     *
     * @return array
     */
    public function getVatAttribute()
    {
        $percentages = $this->basket->items->map(function($item) {
            return [
                'percentage' => $item->price()->vat,
                'net' => $item->model->net * $item->qty,
                'gross' => $item->model->gross * $item->qty
            ];
        })->groupBy('percentage');

        return $percentages->map(function($vat, $key) {
            $netTotal = 0;
            $grossTotal = 0;

            foreach ($vat as $key => $value) {
                $netTotal += $value['net'];
                $grossTotal += $value['gross'];
            }

            return [
                'percentage' => (float)$vat[0]['percentage'],
                'net' => number($netTotal)->get(),
                'gross' => number($grossTotal)->get()
            ];
        });
    }
}
