<?php

use App\Basket\Support\Number;

/**
 * Converts a multidimensional array to an object.
 *
 * @return object
 */
function array_to_object($array)
{
    return json_decode(json_encode($array));
}

/**
 * Gets a number instance for the given numeric value.
 *
 * @return App\Basket\Support\Number
 */
function number($number = 0)
{
    return Number::make($number);
}
