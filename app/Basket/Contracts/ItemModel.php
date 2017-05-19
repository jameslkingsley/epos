<?php

namespace App\Basket\Contracts;

interface ItemModel
{
    /**
     * Gets the display title for the model.
     *
     * @return string
     */
    public function getTitleAttribute() : string;

    /**
     * Gets any meta info for the model.
     * Eg. Weight, pieces per pack.
     *
     * @return array
     */
    public function getMetaAttribute() : array;
}
