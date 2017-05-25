<?php

namespace App\Basket\Traits;

use App\Basket\Support\Number;

trait AutoAttributes
{
    /**
     * Handles calls to undefined functions.
     * This will handle all attributes.
     *
     * @return any
     */
    public function __call($name, $params)
    {
        $method = camel_case(substr($name, 3, strlen($name) - 12));
        $value = $this->$method($params);

        if ($value instanceof Number) {
            return $value->normal()->display();
        }

        return $value;
    }
}
