<?php

namespace App\Basket;

interface ItemModel
{
    /**
     * Gets the display title for the model.
     *
     * @return string
     */
    public function title();

    /**
     * Gets the retail price for the model.
     *
     * @return float
     */
    public function price();

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function meta();
}
