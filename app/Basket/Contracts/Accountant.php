<?php

namespace App\Basket\Contracts;

use App\Basket;
use App\Basket\Support\Number;

interface Accountant
{
    /**
     * Gets the net amount.
     * Excludes VAT.
     *
     * @return App\Basket\Support\Number
     */
    public function net() : Number;

    /**
     * Gets the gross amount.
     * Includes VAT.
     *
     * @return App\Basket\Support\Number
     */
    public function gross() : Number;

    /**
     * Gets the VAT amount.
     *
     * @return App\Basket\Support\Number
     */
    public function vat() : Number;
}
