<?php

namespace App\Basket\Constraints;

use App\Basket\Basket;

abstract class Constraint
{
    /**
     * Error messages collection.
     *
     * @var Collection
     */
    public $reasons;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct()
    {
        $this->reasons = collect();
    }

    /**
     * Checks if the constraint passes.
     *
     * @return boolean
     */
    public function passes()
    {
        $methods = [];

        foreach (func_get_args() as $method) {
            $methods[] = $this->$method();
        }

        return $this->assertAllTrue($methods);
    }

    /**
     * Asserts that all the given arguments are true.
     *
     * @return boolean
     */
    public function assertAllTrue()
    {
        $bools = func_get_args();

        if (is_array(func_get_arg(0))) {
            $bools = func_get_arg(0);
        }

        return ! collect($bools)->contains(false);
    }

    /**
     * Pushes a new reason or gets the first one.
     *
     * @return string|self
     */
    public function reason($message = '')
    {
        if ($message === '') {
            return $this->reasons->first();
        }

        $this->reasons->push($message);

        return false;
    }
}
