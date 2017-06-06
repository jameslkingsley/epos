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
     * Asserts that all the given arguments are true.
     *
     * @return boolean
     */
    public function assertAllTrue()
    {
        return ! collect(func_get_args())->contains(false);
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

        return $this;
    }
}
