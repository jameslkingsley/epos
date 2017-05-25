<?php

namespace App\Basket\Support;

class Number
{
    /**
     * The number.
     *
     * @var int|float
     */
    protected $number;

    /**
     * Currency symbols map.
     *
     * @var array
     */
    protected $symbols = [
        'gbp' => '£',
        'usd' => '$'
    ];

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct($number = 0)
    {
        $this->number = $number;
    }

    /**
     * Gets a string representation of the number.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->number;
    }

    /**
     * Makes a number instance.
     *
     * @return any
     */
    public static function make($number)
    {
        return new static($number);
    }

    /**
     * Formats to the given decimal places, with no rounding.
     *
     * @return string
     */
    public function places(int $places = 2)
    {
        return number_format(
            floor($this->number * pow(10, $places)) / pow(10, $places),
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
        return $this->symbol() . $this->places(2);
    }

    /**
     * Gets the normalised version of the number.
     * Converts pences to pounds.
     *
     * @return self
     */
    public function normal()
    {
        $this->number = $this->number / 100;

        return $this;
    }

    /**
     * Gets the inverted value.
     *
     * @return int|float
     */
    public function inverted()
    {
        return -$this->number;
    }

    /**
     * Sets the number to its floor.
     *
     * @return self
     */
    public function floor()
    {
        $this->number = floor($this->number);

        return $this;
    }

    /**
     * Sets the number to its ceiling.
     *
     * @return self
     */
    public function ceil()
    {
        $this->number = ceil($this->number);

        return $this;
    }

    /**
     * Gets to the nearest integer.
     * Doesn't actually round anything.
     *
     * @return self
     */
    public function round()
    {
        $this->number = intval($this->number);

        return $this;
    }

    /**
     * Apply a function to the underlying number
     *
     * @param callable $callable
     * @return $this
     */
    public function apply(callable $closure)
    {
        $this->number = call_user_func($closure, $this->number);

        return $this;
    }

    /**
     * Gets the number.
     *
     * @return int|float
     */
    public function get()
    {
        return $this->number;
    }

    /**
     * Sums the given number instance arguments.
     * Arguments are dynamic.
     *
     * @return self
     */
    public function sum()
    {
        $total = 0;

        foreach (func_get_args() as $n) {
            $total += $n->get();
        }

        return static::make($total);
    }
}
