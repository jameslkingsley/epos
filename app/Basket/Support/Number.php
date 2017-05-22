<?php

namespace App\Basket\Support;

use Numbers\Number as NumbersPackage;

class Number extends NumbersPackage
{
    /**
     * Gets a string representation of the number.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Makes a number instance.
     *
     * @return any
     */
    public static function make($number)
    {
        return static::n($number);
    }

    /**
     * Formats to the given decimal places, with no rounding.
     *
     * @return string
     */
    public function places(int $places = 2)
    {
        return number_format(
            floor($this->get() * pow(10, $places)) / pow(10, $places),
            $places
        );
    }
}
