<?php

namespace App\Basket\Traits;

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

        return $this->$method($params)->normal()->display();
    }
}
