<?php

namespace App\Basket\Barcodes;

class Lottery extends Barcode
{
    /**
     * Resolves the barcode to an item.
     *
     * @return App\Basket\Models\Item
     */
    public function resolve($barcode)
    {
        return $this->item->first();
    }
}
