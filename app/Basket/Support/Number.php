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
        $this->number = -$this->number;

        return $this;
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
        $elements = func_get_args();

        if (is_array(func_get_args()[0])) {
            $elements = func_get_args()[0];
        }

        foreach ($elements as $n) {
            $total += $n->get();
        }

        return static::make($total);
    }

    /**
     * Applies a percentage cut of the number.
     * Always rounds down.
     *
     * @return self
     */
    public function cut(float $cut)
    {
        $this->number = floor($this->number * $cut);

        return $this;
    }

    /**
     * Multiplies the number by the given number.
     *
     * @return self
     */
    public function times($coef)
    {
        $this->number = $this->number * $coef;

        return $this;
    }

    /**
     * Checks if the number is greater than.
     *
     * @return boolean
     */
    public function gt($number)
    {
        $number = $number instanceof Number ? $number->get() : $number;

        return $this->number > $number;
    }

    /**
     * Checks if the number is greater than or equal to.
     *
     * @return boolean
     */
    public function gte($number)
    {
        $number = $number instanceof Number ? $number->get() : $number;

        return $this->number >= $number;
    }

    /**
     * Checks if the number is less than.
     *
     * @return boolean
     */
    public function lt($number)
    {
        $number = $number instanceof Number ? $number->get() : $number;

        return $this->number < $number;
    }

    /**
     * Checks if the number is less than or equal to.
     *
     * @return boolean
     */
    public function lte($number)
    {
        $number = $number instanceof Number ? $number->get() : $number;

        return $this->number <= $number;
    }
}
