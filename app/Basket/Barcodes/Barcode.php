<?php

namespace App\Basket\Barcodes;

use App\Basket\Models\Item;

abstract class Barcode
{
    /**
     * Item instance.
     *
     * @var App\Basket\Models\Item
     */
    protected $item;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct()
    {
        $this->item = new Item;
    }
}
