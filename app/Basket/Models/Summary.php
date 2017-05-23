<?php

namespace App\Basket\Models;

use App\Basket\Basket;
use Jenssegers\Model\Model;

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
     * Gets the balance of the basket.
     *
     * @return float
     */
    public function getBalanceAttribute()
    {
        return number(
            $this->basket->items->balance()->get() +
            $this->basket->payments->balance()->get()
        )->places(2);
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
                'net' => $item->model()->net() * $item->qty,
                'gross' => $item->model()->gross() * $item->qty
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
                'net' => number($netTotal)->places(),
                'gross' => number($grossTotal)->places()
            ];
        });
    }
}
