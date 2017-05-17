<?php

namespace App\Basket;

use App\Basket;

interface Accountant
{
    /**
     * Gets the net amount.
     * Excludes VAT.
     *
     * @return float
     */
    public function net(Basket $basket = null);

    /**
     * Gets the gross amount.
     * Includes VAT.
     *
     * @return float
     */
    public function gross(Basket $basket = null);

    /**
     * Gets the VAT amount.
     *
     * @return float
     */
    public function vat(Basket $basket = null);
}
