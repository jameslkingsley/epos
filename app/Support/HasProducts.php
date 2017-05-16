<?php

namespace App\Support;

trait HasProducts
{
    /**
     * Gets the collection of products.
     *
     * @return Collection App\Product
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
