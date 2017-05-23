<?php

namespace App\Basket\Support;

use Numbers\Number as NumbersPackage;

class Number extends NumbersPackage
{
    protected $symbols = [
        'gbp' => '£',
        'usd' => '$'
    ];

    /**
     * Gets a string representation of the number.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->get();
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

    /**
     * Gets the symbol for the given currency.
     * Returns null if not found.
     *
     * @return string
     */
    public function symbol(string $currency = 'gbp')
    {
        // TODO Use currency from environment
        return array_key_exists($currency, $this->symbols) ? $this->symbols[$currency] : null;
    }

    /**
     * Gets the string representation of the number.
     * Includes currency symbol.
     *
     * @return string
     */
    public function display()
    {
        return "{$this->symbol()}{$this->places(2)}";
    }
}
